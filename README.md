## Digi Store Hub

In the digital world's fast pace, the demand for instant access to digital products is soaring. **DigiStoreHub** stands out as a pioneering e-commerce platform specifically for digital products. Our aim is to connect innovative digital content creators with tech-savvy consumers. Catering to a variety of digital needs – from ebooks and software to digital art and online courses – **DigiStoreHub** is your one-stop hub for all things digital, offering an intuitive, secure, and seamless shopping experience.

<br />

### Website & documentation

- Website: https://digistorehub.saadouchama.com/graphiql
- Documentation: https://app.swaggerhub.com/apis/SOUFIANOUMALEK_1/DigiStoreHub/1.0.0

### Features:

- Built with the latest **[Laravel](https://laravel.com/docs/9.x/)** framework for a robust backend experience.
- Uses **[GraphQL](https://lighthouse-php.com/6/getting-started/installation.html)** for efficient, flexible data querying.
- Integrates **[MongoDB](https://www.mongodb.com/compatibility/mongodb-laravel-integration)**, a NoSQL database, for scalable data management.
- Responsive and user-friendly interface.

<br />

## Getting Started

> **Step #1** - Clone the project

```bash
$ git clone https://github.com/saadouchama/DigiStoreHub.git
$ cd DigiStoreHub
```

<br />

> **Step #2** - Install Composer Dependencies

```bash
$ composer install
```

<br />

> **Step #3** - Set Up Environment Variables

Copy the `.env.example` file to a new file named `.env`, and update it with your database and other settings.

```bash
$ cp .env.example .env
```

<br />

> **Step #4** - Generate Application Key

```bash
$ php artisan key:generate
```

<br />

> **Step #5** - Migrate and Seed the Database (if applicable)

```bash
$ php artisan migrate
$ php artisan db:seed
```

<br />

> **Step #6** - Run the Application

```bash
$ php artisan serve
```

The application will be served at `localhost:8000`.

<br />

## Project Structure

<details>
<summary>Expand to view the project structure</summary>

```plaintext
/digistorehub
    /app
    /bootstrap
    /config
    /database
    /graphql
    /public
    /resources
    /routes
    /storage
    /tests
    /vendor
```

</details>

<br />

## API Documentation

Explore the GraphQL API via the integrated GraphiQL interface at `localhost:8000/graphiql`.

### Team Members

- **[Saad OUCHAMA](https://www.linkedin.com/in/saadouchama/)**
- **[Soufian OUMALEK](https://www.linkedin.com/in/soufian-oumalek-bb3b42215/)**
