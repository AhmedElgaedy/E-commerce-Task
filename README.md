# E-Commerce API

This is a simple RESTful API for managing products and orders in an e-commerce system.


## Authentication

Authentication is handled using Laravel Sanctum. To access protected routes, include the Bearer token in the `Authorization` header of your requests.

### User Authentication Endpoints

#### Register User

- **Endpoint**: `POST /register`
- **Request Body**:
    ```json
    {
        "name": "John Doe",
        "email": "johndoe@example.com",
        "password": "password",
        "password_confirmation": "password"
    }
    ```
- **Response**:
    - **201 Created**:
    ```json
    {
        "message": "User registered successfully",
        "token": "your_access_token",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "johndoe@example.com"
        }
    }
    ```
    - **422 Unprocessable Entity**:
    ```json
    {
        "email": ["The email has already been taken."],
        "password": ["The password confirmation does not match."]
    }
    ```

#### Login User

- **Endpoint**: `POST /login`
- **Request Body**:
    ```json
    {
        "email": "johndoe@example.com",
        "password": "password"
    }
    ```
- **Response**:
    - **200 OK**:
    ```json
    {
        "message": "Login successful",
        "token": "your_access_token",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "johndoe@example.com"
        }
    }
    ```
    - **401 Unauthorized**:
    ```json
    {
        "message": "Invalid login details"
    }
    ```

#### Logout User

- **Endpoint**: `POST /logout`
- **Headers**:
    - `Authorization: Bearer your_access_token`
- **Response**:
    - **200 OK**:
    ```json
    {
        "message": "Logged out successfully"
    }
    ```

#### Get User Profile

- **Endpoint**: `GET /profile`
- **Headers**:
    - `Authorization: Bearer your_access_token`
- **Response**:
    - **200 OK**:
    ```json
    {
        "id": 1,
        "name": "John Doe",
        "email": "johndoe@example.com"
    }
    ```

### Product Management Endpoints

#### Get Products

- **Endpoint**: `GET /products`
- **Query Parameters**:
    - `name`: (optional) Filter products by name
    - `min_price`: (optional) Filter products by minimum price
    - `max_price`: (optional) Filter products by maximum price
- **Response**:
    - **200 OK**:
    ```json
    {
        "data": [
            {
                "id": 1,
                "name": "Test Product",
                "price": 100.00,
                "description": "This is a test product.",
                "stock": 50
            }
        ],
        "meta": {
            "current_page": 1,
            "last_page": 1,
            "per_page": 10,
            "total": 1
        }
    }
    ```

#### Create Product

- **Endpoint**: `POST /products`
- **Request Body**:
    ```json
    {
        "name": "New Product",
        "price": 150.00,
        "description": "This is a new product.",
        "stock": 30
    }
    ```
- **Response**:
    - **201 Created**:
    ```json
    {
        "id": 2,
        "name": "New Product",
        "price": 150.00,
        "description": "This is a new product.",
        "stock": 30
    }
    ```

#### Update Product

- **Endpoint**: `PUT /products/{id}`
- **Request Body**:
    ```json
    {
        "name": "Updated Product",
        "price": 175.00,
        "description": "This is an updated product.",
        "stock": 25
    }
    ```
- **Response**:
    - **200 OK**:
    ```json
    {
        "id": 2,
        "name": "Updated Product",
        "price": 175.00,
        "description": "This is an updated product.",
        "stock": 25
    }
    ```

### Order Management Endpoints

#### Create Order

- **Endpoint**: `POST /orders`
- **Request Body**:
    ```json
    {
        "products": [
            {
                "id": 1,
                "quantity": 2
        

