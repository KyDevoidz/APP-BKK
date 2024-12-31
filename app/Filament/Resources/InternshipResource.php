<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternshipResource\Pages;
use App\Models\Internship;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InternshipResource extends Resource
{
    protected static ?string $model = Internship::class;
    public static ?string $navigationGroup = "Management Data";
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Card 1: Informasi Siswa dan Prakerin
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('student_id')
                            ->label('NISN')
                            ->options(Student::all()->pluck('nisn', 'id'))
                            ->searchable()
                            ->required()
                            ->placeholder('Pilih siswa')
                            ->helperText('Pilih siswa yang mengikuti program Prakerin'),
                        Forms\Components\TextInput::make('company_name')
                            ->label('Nama Perusahaan')
                            ->placeholder('Masukkan nama perusahaan')
                            ->required()
                            ->helperText('Contoh: PT. XYZ'),
                        Forms\Components\TextInput::make('mentor_name')
                            ->label('Nama Mentor')
                            ->placeholder('Masukkan nama mentor')
                            ->required()
                            ->helperText('Contoh: Budi Santoso'),
                        Forms\Components\TextInput::make('location')
                            ->label('Alamat Prakerin')
                            ->placeholder('Masukkan alamat prakerin')
                            ->required()
                            ->helperText('Contoh: Jl. Kediri No. 123, Kediri, Jawa Timur'),
                    ])
                    ->columns(2), // Dua kolom untuk tata letak yang lebih rapi

                // Card 2: Waktu dan Status Prakerin
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->native(false)
                            ->required()
                            ->helperText('Pilih tanggal mulai prakerin'),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->required()
                            ->native(false)
                            ->helperText('Pilih tanggal selesai prakerin'),
                        Forms\Components\Select::make('status')
                            ->label('Status Prakerin')
                            ->options([
                                'ongoing' => 'Dalam Proses',
                                'completed' => 'Selesai',
                                'canceled' => 'Dibatalkan',
                            ])
                            ->placeholder('Masukkan status prakerin')
                            ->required()
                    ])
                    ->columns(2), // Dua kolom untuk tata letak yang lebih rapi
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.nisn')
                    ->label('NISN')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable(),

                // Kolom Status dengan Badge
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status Prakerin')
                    ->badge(static function (string $state): string {
                        return match ($state) {
                            'ongoing' => 'gray',
                            'canceled' => 'warning',
                            'completed' => 'success',
                        };
                    })
                    ->colors([
                        'primary' => 'ongoing',    // Primary color for 'ongoing'
                        'success' => 'completed',  // Green color for 'completed'
                        'danger' => 'canceled',    // Red color for 'canceled'
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('mentor_name')
                    ->label('Nama Mentor')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter berdasarkan status atau kolom lainnya jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInternships::route('/'),
            'create' => Pages\CreateInternship::route('/create'),
            'edit' => Pages\EditInternship::route('/{record}/edit'),
        ];
    }
}
