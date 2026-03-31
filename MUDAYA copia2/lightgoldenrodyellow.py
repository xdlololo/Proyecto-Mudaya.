#!/usr/bin/env python3
import os
import sys

def analizar_proyecto(ruta_proyecto):
    informe = []
    for raiz, carpetas, archivos in os.walk(ruta_proyecto):
        for archivo in archivos:
            ruta = os.path.join(raiz, archivo)
            informe.append(f"- {ruta}")
    return informe

def guardar_md(informe, ruta_destino):
    with open(ruta_destino, "w") as f:
        f.write("# Informe de Proyecto\n\n")
        for linea in informe:
            f.write(linea + "\n")

def main():
    if len(sys.argv) < 3:
        print("Uso: python3 lightgoldenrodyellow.py <carpeta_proyecto> <ruta_informe.md>")
        sys.exit(1)

    carpeta_proyecto = sys.argv[1]
    ruta_informe = sys.argv[2]

    print(f"Analizando proyecto en: {carpeta_proyecto}")
    informe = analizar_proyecto(carpeta_proyecto)

    print(f"Guardando informe en: {ruta_informe}")
    guardar_md(informe, ruta_informe)

    print("¡Hecho!")

if __name__ == "__main__":
    main()