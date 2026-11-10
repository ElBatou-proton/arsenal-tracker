## About Arsenal Tracker

Arsenal Tracker is a Laravel application that tracks weapons and ammunition for law enforcement agencies or army units.

## Features

- Track weapon and ammunition usage
- Track weapon and ammunition inventory
- Track weapon and ammunition maintenance
- Track weapon and ammunition repairs
- Track weapon and ammunition accidents
- Track weapon and ammunition theft
- Track weapon and ammunition loss
- Track weapon and ammunition disposal
- Track weapon and ammunition transfer
- Track weapon and ammunition return
- Track weapon and ammunition destruction

## Installation
TODO

## Development
This projects uses laravel sail for local development.
At the root of the folder you can execute on the terminal:

```bash
./vendor/bin/sail up
```

To add a new admin user you can run:

```bash
./vendor/bin/sail php artisan make:filament-user
```

Then you can visit your admin panel at `/admin`


## Specifications

### Admin section
- The system will have owners that can be assigned to weapons, this owner is from the army or police unit, so they will have a rank
- The rank will be a dropdown selection from the system and we can add more ranks as needed
- The system will have different types of weapons, and we can add more as needed: 
  - Firearms
  - Knives
  - Explosives
  - Other
- The system will have different types of ammunition, and we can add more as needed: 
  - Bullets
  - Shells
  - Grenades
  - Other
- Some weapons won't have an owner but we still need to register who has them
- When a weapon leaves the armory we need to track who has it and when it returns with full date and time, tracking the time it was taken and the time it was returned for that we will need a new table: weapon_assignments
- this table will have the following columns:
  - weapon_id
  - owner_id
  - assigned_at
  - returned_at
  - order_by (the person who ordered the weapon to be assigned)
  - reason (the reason why the weapon was assigned)
  - details (any additional details about the assignment)
  - status (active, returned, lost, stolen, destroyed)
  - destination (where the weapon was taken to)

  ### Frontend section
  - The main page will display a simple form where the user can enter the weapon serial number
  - The form is submitted and the system will display the weapon details and the current status, including the owner and the last time it was assigned
  - with additional buttons to open a new form to:
    - assign the weapon to a new owner
    - register when the weapon left the armory
    - return the weapon to the armory
    - mark the weapon as lost/stolen/destroyed
    - view the weapon history
