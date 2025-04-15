<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SemesterResource\Pages;
// use App\Filament\Resources\SemesterResource\RelationManagers; // Jika ada
use App\Models\Semester;
use App\Models\TahunAjaran; // Import TahunAjaran
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Validation\Rules\In; // Untuk validasi Rule::in

class SemesterResource extends Resource
{
    protected static ?string $model = Semester::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->label('Nama Semester')
                    ->options([
                        Semester::TYPE_GANJIL => 'Ganjil',
                        Semester::TYPE_GENAP => 'Genap',
                    ])
                    ->required()
                    ->default(Semester::TYPE_GANJIL)
                    ->native(false),
                Select::make('tahun_ajaran_id')
                    ->relationship('tahunAjaran', 'nama_tahun') // Sesuaikan 'nama_tahun'
                    ->required()
                    ->searchable()
                    ->preload() // Tambahkan preload untuk pengalaman pengguna lebih baik
                    ->native(false),
                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama') // Menggunakan accessor dari Model
                    ->label('Nama Semester')
                    ->searchable(isIndividual: false, isGlobal: false) // Searchable di accessor perlu trik khusus
                    // Jika perlu search/sort by type, tambahkan kolom type tersembunyi atau sort/search langsung ke type
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                         return $query->orderBy('type', $direction); // Sort berdasarkan type
                     }),
                TextColumn::make('tahunAjaran.nama_tahun') // Sesuaikan 'nama_tahun'
                    ->label('Tahun Ajaran')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                     ->label('Nama Semester')
                     ->options([
                         Semester::TYPE_GANJIL => 'Ganjil',
                         Semester::TYPE_GENAP => 'Genap',
                     ]),
                 TernaryFilter::make('is_active')
                     ->label('Status Aktif'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(), // Biasanya tidak perlu jika pakai soft delete
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    // ... (getRelations, getPages, getEloquentQuery sama seperti prompt sebelumnya) ...
     public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSemesters::route('/'),
            'create' => Pages\CreateSemester::route('/create'),
            'edit' => Pages\EditSemester::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
