import { Entity, PrimaryGeneratedColumn, Column } from 'typeorm';

@Entity('role_m')
export class Role {
  @PrimaryGeneratedColumn()
  id: number;

  @Column()
  role: string;
}