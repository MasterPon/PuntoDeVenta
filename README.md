# Proyecto Punto de Venta PHP

## Flujo de trabajo con Git y GitHub

Este proyecto utiliza un modelo simplificado del flujo **Git Flow** para gestionar el desarrollo, mantenimiento y liberación de versiones de forma organizada y colaborativa.

---

## Estructura de ramas

| Rama         | Descripción                                   |
|--------------|-----------------------------------------------|
| `main`       | Rama principal que contiene la versión en producción estable. Solo se fusionan versiones probadas. |
| `develop`    | Rama de desarrollo donde se integran todas las funcionalidades nuevas antes de pasarlas a producción. |
| `feature/*`  | Ramas temporales que contienen nuevas funcionalidades o mejoras específicas. Parten de `develop`. |
| `release/*`  | Ramas para preparar versiones candidatas antes de su liberación a producción. Se crean desde `develop`. |
| `hotfix/*`   | Ramas para corregir errores críticos en producción. Se crean desde `main` y luego se integran a `develop`. |

---

## Ejemplo simulado de commits y merges

### Paso 1: Crear rama de desarrollo

```bash
git checkout main
git checkout -b develop
git push -u origin develop
