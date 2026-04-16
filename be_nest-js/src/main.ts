import { ValidationPipe } from '@nestjs/common';
import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module';
import { AuditInterceptor } from '@/tools/audit.interceptor';

async function bootstrap() {
  const app = await NestFactory.create(AppModule);
  app.enableCors({
    origin: 'http://localhost:3001',
    credentials: true,
  })
  app.useGlobalPipes(
    new ValidationPipe()
  );
  app.useGlobalInterceptors(new AuditInterceptor());
  await app.listen(3000);
}
bootstrap();