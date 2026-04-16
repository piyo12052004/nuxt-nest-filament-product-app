import { Controller, Get, Post, Body, Query, UseGuards, Put, ParseIntPipe, Param, Delete, Req } from '@nestjs/common';
import { ProductsService } from './products.service';
import { CreateProductDto } from './dto/create-product.dto';
import { GetProductDto } from './dto/get-product.dto';
import { JwtAuthGuard } from '@/auth/jwt-auth.guard';
import { UpdateProductDto } from './dto/update-product.dto';

@Controller('api/products')
@UseGuards(JwtAuthGuard)
export class ProductsController {
  constructor(private service: ProductsService) { }

  @Get()
  getAll(@Query() query: GetProductDto) {
    return this.service.findAll(query);
  }

  @Post()
  create(@Body() body: CreateProductDto, @Req() req: any) {
    const userId = req.user.userId;

    return this.service.create(body, userId);
  }

  @Put(':id')
  async update(
    @Param('id', ParseIntPipe) id: number,
    @Body() dto: UpdateProductDto, @Req() req: any
  ) {
    const userId = req.user.userId;
    return this.service.update(id, dto,userId);
  }

  @Delete(':id')
  async delete(
    @Param('id', ParseIntPipe) id: number,
  ) {
    return this.service.delete(id);
  }
}