# GraphQL Schema Documentation

## 📅 Custom Scalar Types

### DateTime
- **Description**: A datetime string with the format `Y-m-d H:i:s`, e.g., `2024-03-25 13:43:32`.
- **Usage**: Used for fields that require date and time information.

### Upload
- **Description**: A custom scalar used for file upload functionality.
- **Usage**: Primarily used in mutations that involve uploading files.

## 🔎 Query Type

The `Query` type defines the entry points for querying data in the GraphQL schema.

| Field       | Arguments                                                                                               | Description                                | Returns          |
|-------------|---------------------------------------------------------------------------------------------------------|--------------------------------------------|------------------|
| `user`      | `id`: ID, `email`: String                                                                               | Find a single user by ID or email.         | `User`           |
| `users`     | `name`: String                                                                                          | List multiple users, filtered by name.     | `[User!]!`       |
| `me`        | None                                                                                                    | Fetch the currently authenticated user.    | `User`           |
| `products`  | None                                                                                                    | Fetch all products.                        | `[Product!]!`    |
| `product`   | `id`: ID!                                                                                               | Fetch a single product by ID.              | `Product!`       |

## 🚹 User Type

Represents a user in the application.

| Field                | Type          | Description                            |
|----------------------|---------------|----------------------------------------|
| `id`                 | ID!           | Unique primary key.                    |
| `name`               | String        | Non-unique name.                       |
| `email`              | String        | Unique email address.                  |
| `email_verified_at`  | DateTime      | When the email was verified.           |
| `orders`             | [Order]       | The user's orders.                     |
| `stripe_id`          | String        | The user stripe ID.                    |
| `card_brand`         | String        | The user card brand.                   |
| `card_last_four`     | String        | The user card last four digits.        |
| `trial_ends_at`      | DateTime      | The user trial ends at.                |
| `created_at`         | DateTime      | When the account was created.          |
| `updated_at`         | DateTime      | When the account was last updated.     |

## 🛍️ Product Type

Represents a product in the application.

| Field          | Type           | Description                    |
|----------------|----------------|--------------------------------|
| `id`           | ID!            | Unique identifier.             |
| `name`         | String!        | Product name.                  |
| `description`  | String!        | Product description.           |
| `price`        | Float!         | Product price.                 |
| `category`     | String!        | Product category.              |
| `tags`         | [String!]!     | Product tags.                  |
| `images`       | [String!]!     | Product images.                |
| `average_rating` | Float       | Average rating of the product. |
| `ratings_count`  | Int          | Number of ratings.             |
| `reviews`        | [Review]     | Product reviews.               |

## 🛒 Order Type and Related Types

Represents an order placed by a user, including order items and product details in the order.

### Order

| Field          | Type                | Description                       |
|----------------|---------------------|-----------------------------------|
| `id`           | ID!                 | Unique identifier for the order.  |
| `userId`       | ID!                 | ID of the user who placed the order. |
| `products`     | [OrderProduct!]!   | List of products in the order.    |
| `totalPrice`   | Float               | Total price of the order.         |
| `status`       | String              | Status of the order.              |
| `date`         | String              | Date when the order was placed.   |

### OrderProduct

| Field        | Type      | Description                            |
|--------------|-----------|----------------------------------------|
| `productId`  | ID!       | The product ID in the order.           |
| `quantity`   | Int!      | Quantity of the product.               |

## 💬 Review Type

Represents a review of a product.

| Field       | Type      | Description                        |
|-------------|-----------|------------------------------------|
| `id`        | ID!       | Unique identifier for the review.  |
| `product`   | ID!       | ID of the product being reviewed.  |
| `user`      | ID!       | ID of the user who wrote the review.|
| `comment`   | String!   | The review comment.                |
| `rating`    | Float!    | The rating given.                  |
| `created_at`| DateTime! | When the review was created.       |
| `updated_at`| DateTime! | When the review was last updated.  |

## 🛠️ Mutation Type

The `Mutation` type defines operations for creating, updating, and deleting data.

### Examples of Mutations:

- **Create Product**
  - **Input**: `CreateProductInput`
  - **Returns**: `Product`

- **Register User**
  - **Input**: `RegisterInput`
  - **Returns**: `AuthPayload`

- **Login User**
  - **Input**: `LoginInput`
  - **Returns**: `AuthPayload`

- **Update User**
  - **Input**: `UpdateUserInput`, `id`: ID!
  - **Returns**: `User`

These are just a few examples. Each mutation has its specific input requirements and returns a specific type or a Boolean in cases such as logout.

## 📝 Input Types

Input types are used in mutations to pass data. Examples include `CreateProductInput`, `RegisterInput`, `LoginInput`, etc. Each input type requires specific fields to be filled, like name, email, password for user registration.

## Conclusion

This GraphQL schema provides a solid foundation for a web application managing users, products, orders, and reviews. Through queries, users can fetch data, while mutations allow for data manipulation, including registering users, adding products, creating orders, and more. Custom scalars like `DateTime` and `Upload` enhance functionality by allowing for specialized data types.
