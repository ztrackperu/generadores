# generadores

#MODIFICACION PARA ALIAS 20/02/2026
**Flujo completo:**
```
ListaDeGraficos → merge imei con tabla dispositivos_alias
    ├── tiene alias en MySQL  → muestra el alias
    └── no tiene              → muestra "SIN DESCRIPCION" (gris/itálica)

Click en celda Descripción → input inline
    ├── Enter / ✓  → POST guardarAlias → MySQL → actualiza celda
    ├── Escape / ✗ → restaura texto original
    └── vacío      → marca is-invalid, no guarda