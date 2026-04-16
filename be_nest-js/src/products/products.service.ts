import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Like, Repository } from 'typeorm';
import { Product } from './product.entity';
import { CreateProductDto } from './dto/create-product.dto';
import { GetProductDto } from './dto/get-product.dto';
import { UpdateProductDto } from './dto/update-product.dto';

@Injectable()
export class ProductsService {
    constructor(
        @InjectRepository(Product)
        private repo: Repository<Product>,
    ) { }

    async findAll(query: GetProductDto) {
        console.log(query);
        let { page = 1, limit = 10, name } = query;

        // pastikan number
        page = Number(page);
        limit = Number(limit);

        const skip = (page - 1) * limit;

        const where: any = {};

        if (name) {
            where.name = Like(`%${name}%`);
        }
        where.status = true;
        const [data, total] = await this.repo.findAndCount({
            where,
            take: limit,
            skip,
            order: {
                id: 'DESC',
            },
        });

        return {
            message: 'success',
            data,
            meta: {
                total,
                page,
                limit,
                lastPage: Math.ceil(total / limit),
            },
        };
    }



    create(data: CreateProductDto, userId: number) {
        const product = this.repo.create({
            name: data.name,
            description: data.description,
            price: data.price,

            status: true,
            created_at: new Date(),
            created_by: userId,
        });

        return this.repo.save(product);
    }

    async update(id: number, dto: UpdateProductDto, userId: number) {
        await this.repo.update(id, {
            name: dto.name,
            description: dto.description,
            price: dto.price,
            updated_by: userId,
            updated_at: new Date(),
        });

        return {
            message: 'success update',
        };
    }

    async delete(id: number) {
        const product = await this.repo.findOne({
            where: { id },
        });

        // 2. kalau tidak ada
        if (!product) {
            throw new NotFoundException('Product tidak ditemukan');
        }

        // 3. update status jadi false
        product.status = false;
        product.updated_at = new Date();

        await this.repo.save(product);

        return {
            message: 'Product berhasil dihapus',
        };
    }
}