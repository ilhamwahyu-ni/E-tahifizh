<?php

namespace App\Filament\Resources\TahunAjaranResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Sekolah; // Import Sekolah model
use App\Models\TmKelas; // Import TmKelas model
use App\Models\User; // Import User model

class RombelsRelationManager extends RelationManager
{
    protected static string $relationship = 'rombels';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_rombongan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('tm_kelas_id')
                    ->label('Kelas')
                    ->relationship('tmKelas', 'level') // Assuming 'level' is the display column
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('sekolah_id')
                    ->label('Sekolah')
                    ->options(Sekolah::query()->pluck('nama', 'id')) // Or use relationship if defined differently
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('guru_id')
                    ->label('Guru Wali Kelas')
                    ->relationship('guru', 'name') // Assuming 'guru' is the relationship name on Rombel model
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_rombongan')
            ->columns([
                Tables\Columns\TextColumn::make('nama_rombongan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tmKelas.level')
                    ->label('Level Kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sekolah.nama')
                    ->label('Sekolah')
                    ->sortable(),
                Tables\Columns\TextColumn::make('guru.name')
                    ->label('Guru Wali Kelas')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                // Or use IconColumn:
                // Tables\Columns\IconColumn::make('is_active')
                //     ->label('Aktif')
                //     ->boolean(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
