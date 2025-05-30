<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
        TextInput::make('name')->required(),
        TextInput::make('email')->email()->required(),

        Select::make('role')
            ->label('Role')
            ->options(Role::pluck('name', 'name')->toArray())
            ->searchable()
            ->required()
            ->default(fn ($record) => $record?->roles()->pluck('name')->first()),

        TextInput::make('password')
            ->password()
            ->required(fn (string $context) => $context === 'create')
            ->dehydrated(fn ($state) => filled($state))
            ->maxLength(255)
            ->label('Password'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('email')->searchable(),
            TextColumn::make('roles.name')->label('Role'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function afterCreate($record, array $data): void
    {
        if (isset($data['role'])) {
            $record->assignRole($data['role']);
        }
    }

    public static function afterUpdate($record, array $data): void
    {
        if (isset($data['role'])) {
            $record->syncRoles([$data['role']]);
        }
    }
}
