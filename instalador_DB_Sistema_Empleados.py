import mysql.connector

def crear_base_de_datos():
    #creo la conexion
    conexion=mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
    )

    cursor = conexion.cursor()

        # Creo la base de datos si no existe
    cursor.execute("CREATE DATABASE IF NOT EXISTS sistema_empleados")
    cursor.execute("USE sistema_empleados")  # Usar la base de datos 'sistema_empleados'

        # Ahora creo la tabla si no existe
    cursor.execute('''CREATE TABLE IF NOT EXISTS empleados (
            codigo INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            apellido VARCHAR(100) NOT NULL,
            documento_identidad BIGINT NOT NULL UNIQUE,
            direccion VARCHAR(255),
            email VARCHAR(255),
            telefono BIGINT,
            foto LONGBLOB,
            estado VARCHAR(255), NOT NULL
                
        )''')

        # Mensaje de éxito
    print("La base de datos y la tabla 'empleados' se crearon correctamente.")
    input("Presiona una tecla para salir")
    


                #cierre del cursor y conexion
    cursor.close()
    conexion.close()

# Se ejecuta 
if __name__ == "__main__":
    crear_base_de_datos()
