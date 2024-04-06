import socket

def main():
    # Configuración del cliente
    host = '127.0.0.1'
    port = 8080

    # Creación del socket del cliente
    client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client_socket.connect((host, port))

    while True:
        # Envía un mensaje al servidor
        message = input("Mensaje: ")
        client_socket.send(bytes(message, "utf-8"))

        # Espera la respuesta del servidor
        response = client_socket.recv(1024).decode("utf-8")
        print("Servidor dice:", response)

    client_socket.close()

if __name__ == "__main__":
    main()
