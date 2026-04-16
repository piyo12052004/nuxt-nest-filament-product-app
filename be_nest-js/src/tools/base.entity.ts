import {
    CreateDateColumn,
    UpdateDateColumn,
    Column,
} from 'typeorm';

export abstract class BaseEntity {
    @CreateDateColumn({ type: 'timestamp' })
    created_at: Date;

    @UpdateDateColumn({ type: 'timestamp' })
    updated_at: Date;

    @Column({ nullable: true })
    created_by?: number;

    @Column({ nullable: true })
    updated_by?: number;
}