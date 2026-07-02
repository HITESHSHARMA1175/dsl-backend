/**
 * Exports the OpenAPI/Swagger spec to a static `openapi.json` file at the
 * project root. Share that file with the team (import into Postman, Insomnia,
 * or paste into https://editor.swagger.io).
 *
 * Run with: npm run export:openapi
 */
import fs from 'fs';
import path from 'path';
import { generateSwaggerSpec } from '../src/config/swagger';

const spec = generateSwaggerSpec({} as any);
const outPath = path.resolve(__dirname, '..', 'openapi.json');

fs.writeFileSync(outPath, JSON.stringify(spec, null, 2), 'utf-8');

const pathCount = Object.keys((spec as any).paths || {}).length;
console.log(`OpenAPI spec written to ${outPath}`);
console.log(`Paths: ${pathCount} | Tags: ${((spec as any).tags || []).length}`);
