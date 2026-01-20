# 🛠️ API REST PHP – PUT & DELETE (Tabla `producto`)

API REST para la tabla `producto`, implementando **PUT** (modificar) y **DELETE** (eliminar).  
Requiere **token de autenticación** y devuelve **respuestas en JSON**.

---

## 📋 Tabla `producto`

| Campo           | Tipo     | Restricciones |
|-----------------|---------|---------------|
| `id`            | INT     | PK, NOT NULL  |
| `nombre`        | VARCHAR | NOT NULL      |
| `precio`        | DECIMAL | NOT NULL      |
| `id_fabricante` | INT     | NOT NULL      |

> Todos los campos son obligatorios para **PUT**.

---

## 🔄 PUT – Modificar producto

**Descripción:** Actualiza todos los campos de un producto por su `id`.

**URL:** `/api/producto.php`  
**Método:** `PUT`  
**Headers:**  

Authorization: Bearer <token>
Content-Type: application/x-www-form-urlencoded


**Body (`x-www-form-urlencoded`)**  

id = 1
nombre = "Nuevo Producto"
precio = 99.99
id_fabricante = 2


**Flujo lógico:**

flowchart LR
A[Cliente] -->|PUT + token| B[API /producto.php]
B --> C{Token válido?}
C -- Sí --> D[Actualizar producto en BD]
C -- No --> E[Retornar error JSON]
D --> F[Retornar éxito JSON]

Ejemplo respuesta éxito

{
  "mensaje": "Producto actualizado correctamente."
}

Ejemplo respuesta error

{
  "error": "No se pudo actualizar el producto."
}

🗑️ DELETE – Eliminar producto

Descripción: Elimina un producto por su id.

URL: /api/producto.php?id=1
Método: DELETE
Headers:

Authorization: Bearer <token>

Flujo lógico:

flowchart LR
A[Cliente] -->|DELETE + token| B[API /producto.php]
B --> C{Token válido?}
C -- Sí --> D[Eliminar producto en BD]
C -- No --> E[Retornar error JSON]
D --> F[Retornar éxito JSON]


Ejemplo respuesta éxito

{
  "mensaje": "Producto eliminado correctamente."
}

Ejemplo respuesta error

{
  "error": "No se pudo eliminar el producto."
}

🧪 Mini-guía Postman
PUT – Modificar producto

1️⃣ Selecciona PUT en Postman
2️⃣ URL: http://localhost/api/producto.php?id=1
3️⃣ Headers:

Authorization: Bearer <token>
Content-Type: application/x-www-form-urlencoded

4️⃣ Body (x-www-form-urlencoded): nombre, precio, id_fabricante
5️⃣ Click Send y revisar JSON
DELETE – Eliminar producto

1️⃣ Selecciona DELETE en Postman
2️⃣ URL: http://localhost/api/producto.php?id=1
3️⃣ Header: Authorization: Bearer <token>
4️⃣ Click Send y revisar JSON

    ⚠️ Nota: Para DELETE, el parámetro id se pasa en la URL (query string).

🔐 Buenas prácticas

    Enviar todos los campos en PUT

    Verificar $_SERVER['REQUEST_METHOD']

    Leer parámetros de $_GET o php://input

    Mantener JSON consistente para errores y éxito

    Documentar endpoints claramente

🎯 Tips pro

    Crear una colección Postman con PUT y DELETE preconfigurados

    Usar diagramas Mermaid para explicar la lógica de la API

    Mantener README limpio y visual usando emojis y bloques de código