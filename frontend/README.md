# Laravel Vue SPA Using Sanctum & Fortify Authentication

## Project setup
```
npm install
```

**IMPORTANT** make sure you have a .env.local file with your API URL added
```
VUE_APP_API_URL=http://localhost:8000
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

## Authentication
Authentication is done by AuthService and Auth store module etc
```
/login
/register
```

## CRUD pages
- /blogs Read, (Delete function)
- /blogs/create Create
- /blogs/view/:id Read
- /blogs/update Read
