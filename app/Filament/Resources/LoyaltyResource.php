<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoyaltyResource\Pages;
use App\Filament\Resources\LoyaltyResource\RelationManagers;
use App\Models\Loyalty;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoyaltyResource extends Resource
{
    protected static ?string $model = Loyalty::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('store_id')
                    ->relationship('store', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('points')
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('store.name'),
                Tables\Columns\TextColumn::make('points'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoyalties::route('/'),
            'create' => Pages\CreateLoyalty::route('/create'),
            'edit' => Pages\EditLoyalty::route('/{record}/edit'),
        ];
    }
}
