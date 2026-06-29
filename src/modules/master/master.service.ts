import { PrismaClient } from '@prisma/client';

export class MasterService {
  constructor(private prisma: PrismaClient) {}

  async getValues(masterHeadId: number) {
    return this.prisma.masterValue.findMany({
      where: { MasterHead: masterHeadId, status: '1' },
      select: { id: true, MasterValue: true },
    });
  }
}
