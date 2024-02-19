###############################################################################
#                                                                             #
#                            GENERADOR DE CODIGOS QR                          #
#                                                                             #
###############################################################################
# @INP: Direccion URL.                                                        #
# @INP: Cantidad de códigos QR a generar.                                     #
# @OUT: Se crea una carpeta con formato fecha + hr + mm. En ella se depositan #
#       todos los archivos JPG de los códigos QR generados.                   #                                                               
# @EXE: Ejemplo de modo ejecucion                                             #
#                                                                             #
#           C:\>generadorqr.py                                                #
#           Bienvenido al generador de códigos QR                             #
#                                                                             #
# Por favor, ingresa la URL base para el código QR: www.freetagsqr.com        #
# Por favor, ingresa la cantidad de códigos QR a generar: 5                   #
#                                                                             #
###############################################################################
# NOTA: es necesario contar con la instalación de Python y sus dependencias.  #
###############################################################################

import os
import qrcode
from datetime import datetime
from colorama import init, Fore, Style

init(autoreset=True)

def generar_codigo_qr(data, numero_serial, carpeta):
    qr = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_L,
        box_size=10,
        border=4,
    )
    qr.add_data(data)
    qr.make(fit=True)

    img = qr.make_image(fill_color="black", back_color="white")

    if not os.path.exists(carpeta):
        os.makedirs(carpeta)

    img_file = os.path.join(carpeta, f"codigo_qr_{numero_serial}.jpg")
    img.save(img_file)
    print(f"{Fore.GREEN}El código QR con el número serial {numero_serial} se ha guardado como {img_file}")

def obtener_historial():
    if not os.path.exists("historial.txt"):
        with open("historial.txt", "w") as f:
            pass
    with open("historial.txt", "r") as f:
        return [line.strip() for line in f.readlines()]

def agregar_a_historial(numero_serial):
    with open("historial.txt", "a") as f:
        f.write(numero_serial + "\n")

def guardar_lote(numero_serial, carpeta):
    
    fecha_actual = datetime.now().strftime("%Y-%m-%d_%H-%M")

    if not os.path.exists(carpeta):
        os.makedirs(carpeta)

    archivo_lote = os.path.join(carpeta, f"lote_{fecha_actual}.txt")
    with open(archivo_lote, "a") as f:
        f.write(numero_serial + "\n")

if __name__ == "__main__":
    print(Fore.YELLOW + "Bienvenido al generador de códigos QR\n")

    url = input("Por favor, ingresa la " + Fore.CYAN + "URL base" + Style.RESET_ALL + " para el código QR: ")
    
    cantidad = int(input("Por favor, ingresa la " + Fore.CYAN + "cantidad de códigos QR" + Style.RESET_ALL + " a generar: "))
    
    print("\n" + Fore.YELLOW + "Generando códigos QR...\n")
    
    # Obtener el historial de números seriales
    historial = obtener_historial()

    # Obtener la carpeta para guardar los archivos
    carpeta = datetime.now().strftime("%Y-%m-%d_%H-%M")
    
    for _ in range(cantidad):
      
        numero_serial = os.urandom(4).hex()
        while numero_serial in historial:
            numero_serial = os.urandom(4).hex()
        
        agregar_a_historial(numero_serial)
        
        # Guardo el número serial en el archivo de lote en la carpeta
        guardar_lote(numero_serial, carpeta)

        # Construyo la URL con el número serial
        url_con_serial = f"{url}/{numero_serial}"

        # Generar el código QR y los guardo en su correspondiente carpeta
        generar_codigo_qr(url_con_serial, numero_serial, carpeta)
    
    print("\n" + Fore.YELLOW + "Proceso completado. Los códigos QR se han generado correctamente.")
