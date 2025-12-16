FROM node:20-alpine AS build

WORKDIR /app
COPY package.json package-lock.json index.html *.json vite.config.ts .env ./
RUN npm install
COPY public ./public
COPY src ./src
RUN npm run build

FROM nginx:alpine
COPY --from=build /app/dist /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY env.js /usr/share/nginx/html/template.env.js
EXPOSE 80

CMD sh -c "envsubst < /usr/share/nginx/html/template.env.js > /usr/share/nginx/html/env.js && nginx -g 'daemon off;'"
