var Tharsis = ( function ( window , undefined) {

    var getURL = function () {
        return location.pathname.split("/");
    }

    var App = {
        init : function () {
            return "Hola que tal";
        }
    }

    return {
        getURL : getURL()
    }

} )( window , undefined);