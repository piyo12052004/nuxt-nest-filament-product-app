import { Injectable, NotFoundException, UnauthorizedException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { User } from './entities/user.entity';
import * as bcrypt from 'bcryptjs';
import { JwtService } from '@nestjs/jwt';

import { RegisterDto } from './dto/register.dto';

@Injectable()
export class AuthService {
    private blacklistedTokens: string[] = []
    constructor(
        @InjectRepository(User)
        private userRepo: Repository<User>,
        private jwtService: JwtService,
    ) { }

    async getUsers(req: Request) {
        const idUsers = (req as any).user.userId;
        const user = await this.userRepo.findOne({
            where: { id: idUsers },
            relations: ['role'],
        });

        if (!user) {
            throw new NotFoundException('User tidak ditemukan');
        }

        return {
            message: 'success',
            data: user,
        };
    }

    // REGISTER
    async register(dto: RegisterDto) {
        const { name, email, password, role_id } = dto;

        const exist = await this.userRepo.findOne({
            where: { email },
        });

        if (exist) {
            throw new UnauthorizedException('Email sudah terdaftar');
        }

        const hash = await bcrypt.hash(password, 10);

        const user = this.userRepo.create({
            name,
            email,
            password: hash,
            role_id,
            created_at: new Date(),
        });

        return this.userRepo.save(user);
    }

    // LOGIN
    async login(email: string, password: string) {
        const user = await this.userRepo.findOne({ where: { email } });

        if (!user) {
            throw new UnauthorizedException('User tidak ditemukan');
        }

        const isMatch = await bcrypt.compare(password, user.password);

        if (!isMatch) {
            throw new UnauthorizedException('Password salah');
        }

        const payload = {
            sub: user.id,
            email: user.email,
        };

        return {
            message: 'Berhasil login',
            access_token: this.jwtService.sign(payload),
        };
    }

    // auth.service.ts
    blacklistToken(token: string) {
        this.blacklistedTokens.push(token)
    }

    isBlacklisted(token: string): boolean {
        return this.blacklistedTokens.includes(token)
    }
}