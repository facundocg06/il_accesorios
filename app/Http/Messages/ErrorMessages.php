<?php

namespace App\Http\Messages;

class ErrorMessages
{
    public const NOT_FOUND = 'No se encontro el recurso ';
    public const UNAUTHORIZED = 'No tiene permisos para realizar esta accion';
    public const FORBIDDEN = 'No tiene permisos para realizar esta accion';
    public const BAD_REQUEST = 'Solicitud invalida';

    public const USER_CREATION_ERROR = 'Hubo un error al crear el usuario';
    public const USER_UPDATE_ERROR = 'Hubo un error al actualizar el usuario';
    public const USER_DELETE_ERROR = 'Hubo un error al eliminar el usuario';
    public const USER_ALREADY_EXIST = 'El usuario con ese correo electrónico ya existe';

    public const CATEGORY_CREATION_ERROR='Hubo un error al registrar la Categoria';
    public const CATEGORY_UPDATE_ERROR='Hubo un error al actualizar la Categoria';
    public const CATEGORY_DELETE_ERROR='Hubo un error al eliminar la Categoria';
    public const CATEGORY_ALREADY_EXIST='La Categoria ya existe';
    public const CATEGORY_NOT_FOUND='La Categoria no existe';

    public const PRODUCT_CREATION_ERROR='Hubo un error al registrar el Producto';
    public const PRODUCT_UPDATE_ERROR='Hubo un error al actualizar el Producto';
    public const PRODUCT_DELETE_ERROR='Hubo un error al eliminar el Producto';
    public const PRODUCT_ALREADY_EXIST='El Producto ya existe';
    public const PRODUCT_NOT_FOUND='El Producto no existe';

    public const SUPPLIER_CREATION_ERROR='Hubo un error al registrar el Proveedor';
    public const SUPPLIER_UPDATE_ERROR='Hubo un error al actualizar el Proveedor';
    public const SUPPLIER_DELETE_ERROR='Hubo un error al eliminar el Proveedor';
    public const SUPPLIER_ALREADY_EXIST='El Proveedor ya existe';
    public const SUPPLIER_NOT_FOUND='El Proveedor no existe';

    public const CUSTOMER_CREATION_ERROR='Hubo un error al registrar el Cliente';
    public const CUSTOMER_UPDATE_ERROR='Hubo un error al actualizar el Cliente';
    public const CUSTOMER_DELETE_ERROR='Hubo un error al eliminar el Cliente';
    public const CUSTOMER_ALREADY_EXIST='El Cliente ya existe';
    public const CUSTOMER_NOT_FOUND='El Cliente no existe';

    public const PURCHASE_CREATION_ERROR='Hubo un error al registrar la Compra';
    public const PURCHASE_UPDATE_ERROR='Hubo un error al actualizar la Compra';
    public const PURCHASE_DELETE_ERROR='Hubo un error al eliminar la Compra';
    public const PURCHASE_ALREADY_EXIST='La Compra ya existe';
    public const PURCHASE_NOT_FOUND='La Compra no existe';

    public const STOCK_CREATION_ERROR='Hubo un error al registrar el producto del proveedor';
    public const STOCK_UPDATE_ERROR='Hubo un error al actualizar el producto del proveedor';
    public const STOCK_DELETE_ERROR='Hubo un error al eliminar el producto del proveedor';
    public const STOCK_ALREADY_EXIST='El producto del proveedor ya existe';
    public const STOCK_NOT_FOUND='El producto del proveedor no existe';


    public const SALE_CREATION_ERROR = 'Hubo un error al realizar la venta';
    public const SALE_UPDATE_ERROR = 'Hubo un error al actualizar la venta';
    public const SALE_DELETE_ERROR = 'Hubo un error al eliminar la venta';
    public const SALE_NOT_FOUND = 'La venta no existe';



}
