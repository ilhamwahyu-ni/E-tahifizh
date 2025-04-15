<?php

namespace App\Filament\Resources\TahunAjaranResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class SemestersRelationManager extends RelationManager
{
    protected static string $relationship = 'semesters';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        1 => 'Ganjil',
                        2 => 'Genap',
                    ])
                    ->required()
                    ->label('Semester'),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->label('Aktif'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Semester')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '1' => 'Ganjil',
                        '2' => 'Genap',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('setAktif')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => !$record->is_active)
                    ->action(function ($record) {
                        DB::transaction(function () use ($record) {
                            $record->tahunAjaran->semesters()
                                ->where('id', '!=', $record->id)
                                ->update(['is_active' => false]);
                            $record->update(['is_active' => true]);
                        });
                        Notification::make()
                            ->success()
                            ->title('Semester berhasil diaktifkan')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
