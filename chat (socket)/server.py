import socket

def main():
    # Configuración del servidor
    host = '127.0.0.1'
    port = 8080

    # Creación del socket del servidor
    server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server_socket.bind((host, port))
    server_socket.listen(1)  # Solo se permite una conexión

    print("Servidor escuchando en {}:{}".format(host, port))

    # Espera a que un cliente se conecte
    client_socket, addr = server_socket.accept()
    print("Cliente conectado desde:", addr)

    while True:
        # Espera a recibir datos del cliente
        data = client_socket.recv(1024).decode("utf-8")
        if not data:
            break
        print("Cliente dice:", data)
        response = input("Respuesta: ")
        client_socket.send(bytes(response, "utf-8"))

    client_socket.close()
    server_socket.close()

if __name__ == "__main__":
    main()
