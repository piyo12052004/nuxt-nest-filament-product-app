import { Body, Controller, Get, Post, Req, UseGuards } from '@nestjs/common';
import { AuthService } from './auth.service';
import { RegisterDto } from './dto/register.dto';
import { LoginDto } from './dto/login.dto';
import { JwtAuthGuard } from './jwt-auth.guard';

@Controller('api/auth')
export class AuthController {
  constructor(private authService: AuthService) { }

  @UseGuards(JwtAuthGuard)
  @Get('get-users')
  getUser(@Req() req: Request) {
    return this.authService.getUsers(req);
    // return req.user
  }
  @Post('register')
  register(@Body() dto: RegisterDto) {
    return this.authService.register(dto);
  }

  @Post('login')
  login(@Body() dto: LoginDto) {
    return this.authService.login(dto.email, dto.password);
  }

  @UseGuards(JwtAuthGuard)
  @Post('logout')
  logout(@Req() req) {
    const token = req.headers.authorization?.split(' ')[1]

    if (token) {
      this.authService.blacklistToken(token)
    }

    return {
      message: 'Logout berhasil'
    }
  }
}