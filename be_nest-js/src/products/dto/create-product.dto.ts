import { IsBoolean, IsNotEmpty, IsNumber, IsOptional, IsString } from 'class-validator';

export class CreateProductDto {
  @IsString()
  @IsNotEmpty()
  name: string;

  @IsBoolean()
  @IsOptional() // biar optional saat create
  status?: boolean;

  @IsString()
  description: string;

  @IsNumber()
  price: number;
}