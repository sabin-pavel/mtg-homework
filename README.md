# MTG - Homework 
Docker + Lumen with Nginx, MySQL, and Memcached

## Context

Magic the Gathering has been a card game for about 20 years (https://en.wikipedia.org/wiki/Magic:TheGathering). The principle is quite simple behind. You have a set of cards that produce mana inside your deck and the other cards of the deck need some mana to be played. The cards that produce mana are called land. The others are spells, rituals, creatures, artifacts, or enchantments.

## Rules

- A deck is a collection of at least 20 cards and a maximum of 30. (60 in the game, but it's easier with a smaller number ;) )
- Land don't have a mana cost
- We should display the average mana cost of the deck even if the number of cards has not reached 20.
- We can't have more than 30 cards in a deck.

## API

You can use the following API to gather the data you need → https://docs.magicthegathering.io/
Inside the card endpoint, you have the CMC, which is the converted mana cost. This is the value you should play with.

## Requirement

Create a new application that allows you to search for cards, add them to a deck, and get the average mana cost of the cards that aren't land inside the deck.
The goal is that you showcase your mastery. Please provide some Readme with an explanation of what you did.

## Clone this repo

```bash
git clone https://github.com/sabin-pavel/mtg-homework.git
cd mtg-homework
```

## Create Lumen App

now, create the app in the `images/php` directory named `app`

```bash
docker run --rm -it -v $(pwd)/images/php:/app $(docker build -q .) composer create-project --prefer-dist laravel/lumen ./app
```

### Configuration

There are two configurations using `.env` files. One `.env` file for docker-compose.yaml and another for the php application.

```sh
# copy both files and make changes to them if needed
cp .env.docker.example .env
cp .env.app.example images/php/app/.env
```

To change configuration values, look in the `docker-compose.yml` file and change the `php` container's environment variables. These directly correlate to the Lumen environment variables.

## Docker Setup

### [Docker for Mac](https://docs.docker.com/docker-for-mac/)

### [Docker for Windows](https://docs.docker.com/docker-for-windows/)

### [Docker for Linux](https://docs.docker.com/engine/installation/linux/)

### Build & Run

```bash
docker-compose up --build -d
```

Navigate to [http://localhost:80](http://localhost:80) or http://mtg-homework (after adding `mtg-homework` in your hosts file) and you should see something like this

### Stop Everything

```bash
docker-compose down
```

## Running Artisan commands

```sh
docker-compose exec php sh
# inside the container
php artisan migrate
php artisan cache:clear
```
