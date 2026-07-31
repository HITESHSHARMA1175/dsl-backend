import { Request, Response, NextFunction } from 'express';
import crypto from 'crypto';
import path from 'path';
import { PutObjectCommand, S3Client } from '@aws-sdk/client-s3';
import { AppError } from '../../shared/utils/appError';
import { successResponse } from '../../shared/utils/response.util';

const region = process.env.AWS_REGION || 'ap-south-1';
const bucket = process.env.AWS_S3_BUCKET;

const s3Client = new S3Client({
  region,
  credentials: process.env.AWS_ACCESS_KEY_ID && process.env.AWS_SECRET_ACCESS_KEY
    ? {
        accessKeyId: process.env.AWS_ACCESS_KEY_ID,
        secretAccessKey: process.env.AWS_SECRET_ACCESS_KEY,
      }
    : undefined,
});

function getS3ObjectUrl(key: string) {
  return `https://${bucket}.s3.${region}.amazonaws.com/${key}`;
}

export async function uploadImage(req: Request, res: Response, next: NextFunction) {
  try {
    if (!req.file) {
      throw new AppError(400, 'No image file provided');
    }

    if (!bucket) {
      throw new AppError(500, 'AWS_S3_BUCKET is not configured');
    }

    if (!req.file.buffer) {
      throw new AppError(400, 'Image file buffer is missing');
    }

    const ext = path.extname(req.file.originalname) || '.jpg';
    const unique = crypto.randomBytes(16).toString('hex');
    const key = `uploads/${Date.now()}-${unique}${ext}`;

    await s3Client.send(new PutObjectCommand({
      Bucket: bucket,
      Key: key,
      Body: req.file.buffer,
      ContentType: req.file.mimetype,
    }));

    return res.status(201).json(successResponse(201, 'Image uploaded', {
      filename: key,
      url: getS3ObjectUrl(key),
    }));
  } catch (error) {
    next(error);
  }
}
