import socket

def main():
    
    host = '127.0.0.1'
    port = 8080

    
    client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client_socket.connect((host, port))

    while True:
        
        message = input("Mensaje: ")
        client_socket.send(bytes(message, "utf-8"))

        
        response = client_socket.recv(1024).decode("utf-8")
        print("Servidor dice:", response)

    client_socket.close()

if __name__ == "__main__":
    main()
