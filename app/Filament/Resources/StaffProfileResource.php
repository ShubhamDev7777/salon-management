<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffProfileResource\Pages;
use App\Filament\Resources\StaffProfileResource\RelationManagers;
use App\Models\StaffProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;


class StaffProfileResource extends Resource
{
    protected static ?string $model = StaffProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('user_id')->relationship('user', 'name')->required(),
            TextInput::make('position')->required(),
            Textarea::make('bio')->rows(3),
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('user.name')->label('Staff Name'),
            TextColumn::make('position'),
            TextColumn::make('bio')->limit(50)->toggleable(),
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
            'index' => Pages\ListStaffProfiles::route('/'),
            'create' => Pages\CreateStaffProfile::route('/create'),
            'edit' => Pages\EditStaffProfile::route('/{record}/edit'),
        ];
    }
}
