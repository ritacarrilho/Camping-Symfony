# TP Symfony Camping

## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Functionalities](#functionalities)
* [Info](#info)
* [Pages](#pages)

## General Info
Travelling agency website with possibility to CRUD the employees and the Trips. Generated fake data stored in Database.
Project developed in Symfony and styled with Bootstrap. Dev environment: Docker and Lando.

## Technologies:
Project created with:
* HTML
* Bootstrap
* Symfony
* MySQL
* Docker
* Lando

## Info
# Services: 
50 mobile-homes (30 belong to private owners) 
10 caravans 
30 places (for tents)  

# Caravans: 
2 places: 15€ 
4 places: 18€ 
6 places: 24€

# Places: 
8m^2: 12€ 
12m^2: 14€ 

# Mobile-homes: 
3 places: 20€ 
4 places: 24€ 
5 places: 27€ 
6 places: 34€ 

# Seasons: 
Opening period: from 05 May to 10 October  
Low season: 05 May to 20 June and 01 September to 10 October 
High season: 21 June to 31 August 

# Tarifs: 
15% tax add in high season 
5% remise per day

# Pool Taxes:  
Kids: 1€ 
Adults: 1,5€ 

# Daily Taxes: 
Kids: 0,35€ 
Adults: 0,60€ 

# Access Types: 
Public 
Admin 
Owner 

# Public Access: 
Make a reservation (formulary that generates an invoice) 
Access to all services and infrastructures 

# Admin Access:  
See all rents and available dates 
Add a new mobile-home (with photo) 
Able to see all invoices and delete them 
Access to client's information: 
    one week after the rent end date 
    If the client agrees one year after the rent end date (send an alert message) 
    Delete invoices 3 years after their creation (send an alert message 
    Access to all owner’s invoices 
    Owner’s information must be deleted a year after the end of the contract with the camping company 

# Owner Access:  
List of rentals (rents planning) 
List of retributions of their rentals 
Retribution Invoice (includes all rentals invoices) 
Made only at the end of season 
Retribution equal to 35% of the rental (daily taxes and pool taxes not included) 

## Structure
Features: 
Make a reservation (ask for permition to store data for 1 year) 
See all available services with photos (types of rentals, daily taxes, pool taxes, seasons dates and taxes) 
Reservation form generates an invoice 

# Admin 
Features: 
See disponibility and planning 
Add and edit rentals 
Access to invoices and be able to cancel them 
Access to invoices of each owner 
Access to owner’s info: 
    Alert to delete all owner’s info 1 week after the contract ends 
    Alert to delete all owner’s info 1 year after the contract ends if owner agrees 
    Alert to delete all invoices 3 years after their creation 

# Owner 
Features: 
See disponibility and planning of their properties 
Retribution’s list of their properties 
Retribution invoice: combination of all rental’s invoices printed at season end 
Owner invoice: retribution equivalent to 35% of location price according to days (excludes the daily and pool taxes 

## Pages 
# Homepage: 
Camping description 

# Services info: 
Available services with photos (types of rentals, daily taxes, pool taxes, seasons dates and taxes 

# Rentals List: 
Caravans, Mobile-homes, emplacements – list available all the time 

Display all and filter by type: 
Label 
Price per day 
Capacity  
Availability dates 

Public: possibility to reserve by date (reservation form)  

Admin:  possibility to add edit, filter by reservations (with date) 

# Invoices: 
Total of days, pool days total, daily taxes total, for each 7 days 5% discount, 15% less in low season 

Admin: access to all invoices with possibility to delete, see invoices by owner 
Alert to delete invoices info 3 years after the rental 

# Owners/partners: 
Admin: Owners/partners information, alert to delete owner’s info a year after the contract ends 
