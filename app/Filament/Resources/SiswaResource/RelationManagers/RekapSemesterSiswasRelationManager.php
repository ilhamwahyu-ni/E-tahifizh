<?php

namespace App\Filament\Resources\SiswaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Semester; // Import Semester model

class RekapSemesterSiswasRelationManager extends RelationManager
{
    protected static string $relationship = 'rekapSemesterSiswas'; // Assuming this is the relationship name

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('catatan_global')
                    ->label('Catatan Global Semester')
                    ->rows(3) // Adjust rows as needed
                    ->maxLength(65535), // Max length for TEXTAREA
                // semester_id and siswa_id are handled by the relation manager
                // If you need to select a semester when creating:
                // Forms\Components\Select::make('semester_id')
                //     ->relationship('semester', 'nama') // Adjust display attribute if needed
                //     ->required()
                //     ->searchable()
                //     ->preload(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // Use semester name or a combination for the title
            ->recordTitle(fn ($record) => 'Rekap Semester: ' . $record->semester?->nama ?? $record->semester_id)
            ->columns([
                Tables\Columns\TextColumn::make('semester.nama') // Assumes 'semester' relationship exists and 'nama' attribute on Semester model
                    ->label('Semester')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('catatan_global')
                    ->label('Catatan Global')
                    ->limit(50) // Limit display length in table
                    ->tooltip(fn ($record) => $record->catatan_global) // Show full text on hover
                    ->wrap(), // Allow text wrapping
            ])
            ->filters([
                // Add filters if needed
            ])
            ->headerActions([
                // Only allow creating if semesters are not automatically generated elsewhere
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // DeleteAction might be needed depending on requirements
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

     // Optional: Modify query if needed, e.g., order by semester start date
     public function getEloquentQuery(): Builder
     {
         return parent::getEloquentQuery()->orderBy(
             Semester::select('tanggal_mulai') // Assuming Semester model has 'tanggal_mulai'
                 ->whereColumn('id', 'rekap_semester_siswas.semester_id') // Correlated subquery
                 ->latest() // Order by the subquery result
         );
         // Or if Semester relationship is eager loaded, you might sort differently
     }
}
