<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    public static ?string $navigationGroup = "Management Data";
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Card 1: Data Pribadi Siswa
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->placeholder('Masukkan nama lengkap siswa')
                            ->required()
                            ->helperText('Contoh: John Doe'),
                        Forms\Components\TextInput::make('nisn')
                            ->label('NISN')
                            ->placeholder('Masukkan NISN siswa')
                            ->required()
                            ->numeric()
                            ->helperText('Nomor Induk Siswa Nasional'),
                    ])
                    ->columnSpan('full') // Card ini memenuhi lebar penuh
                    ->columns(2), // Dua kolom untuk tata letak yang lebih rapi

                // Card 2: Informasi Kontak dan Akademik
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('no_hp')
                            ->prefix('+62')
                            ->label('Nomor HP')
                            ->placeholder('Masukkan nomor HP siswa')
                            ->required()
                            ->helperText('Format nomor HP: +62xxxxxxxxx'),
                        Forms\Components\TextInput::make('alamat')
                            ->label('Alamat')
                            ->placeholder('Masukkan alamat siswa (opsional)')
                            ->helperText('Contoh: Jalan Raya Desa, Kecamatan, Kabupaten, Provinsi'),
                        Forms\Components\TextInput::make('kelas')
                            ->label('Kelas')
                            ->placeholder('Masukkan kelas siswa')
                            ->required()
                            ->helperText('Contoh: XII TKJ 4, XI TKJ 3'),
                        Forms\Components\TextInput::make('walas')
                            ->label('Wali Kelas')
                            ->placeholder('Masukkan nama wali kelas')
                            ->required()
                            ->helperText('Contoh: Ibu Rina'),
                    ])
                    ->columns(2), // Dua kolom untuk tata letak data
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->prefix('+62')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('walas')
                    ->label('Wali Kelas')
                    ->searchable()
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
                // Filter berdasarkan status atau kolom lainnya jika diperlukan
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
            // Relasi tambahan dapat ditambahkan di sini
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
