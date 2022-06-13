
### **Insertar datos con POST**
#### Donde:
- -X : indicamos que utlizaremos el metodo POST
- -d : indicamos la informacion a añadir

```
$ curl -X 'POST' http://localhost:8000/books -d '{"titulo"
:"Nuevo libro","id_autor":1,"id_genero":2}' |jq
```
#### Resultado:
```
{
  "1": {
    "titulo": "Lo que el viento se llevo",
    "id_autor": 2,
    "id_genero": 2
  },
  "2": {
    "titulo": "Cien años de soledad",
    "id_autor": 1,
    "id_genero": 1
  },
  "3": {
    "titulo": "La ciudad y los perros",
    "id_autor": 3,
    "id_genero": 1
  },
  "4": {
    "titulo": "Nuevo libro",
    "id_autor": 1,
    "id_genero": 2
  }
}
```
### **Modificar con PUT**
```
#se actualizo el primer elemento del recurso

$ curl -X 'PUT'   http://localhost:8000/books/1  -d '{"Titu
lo":"Nuevo Libro","id_autor":1,"id_genero":2}'  |jq
```
#### Resultado:
```
{
  "1": {
    "Titulo": "Nuevo Libro",
    "id_autor": 1,
    "id_genero": 2
  },
  "2": {
    "titulo": "Cien años de soledad",
    "id_autor": 1,
    "id_genero": 1
  },
  "3": {
    "titulo": "La ciudad y los perros",
    "id_autor": 3,
    "id_genero": 1
  }
}
```
### **Eliminar datos con DELETE**
```
 curl -X 'DELETE'   http://localhost:8000/books/1   |jq
```
#### Resultado:
```
{
  "2": {
    "titulo": "Cien años de soledad",
    "id_autor": 1,
    "id_genero": 1
  },
  "3": {
    "titulo": "La ciudad y los perros",
    "id_autor": 3,
    "id_genero": 1
  }
}
```
 ### **Autenticacion con Token**

- Necesitamos 1 servidor para el recurso y otro para la autenticacion.

```
#levantamos los servidores
php -S localhost:8000 router.php 

php -s localhost:8001 auth_server.php

```
- Solicitando token al servidor de autenticacion
```
curl http://localhost:8001 -X 'POST' -H 'X-Client-Id: 1' -H 'X-Secret:SuperSecreto!'
```
- validacion y solicitar recurso
```
curl http://localhost:8000/books -H 'X-Token: 5d0937455b6744.68
357201'
```




