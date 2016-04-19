/**
 * Created by Charif on 01/04/2016.
 */

app.factory('AuthFactory', function ($http, $localStorage) {
    return {
        LOGIN: function (URL, data) {
            $http({
                method: 'POST',
                url: URL,
                data: data,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                .success(function (data) {
                    //noinspection JSUnresolvedVariable
                    var $storage = $localStorage.$default({
                        OPENTESTTOKEN: null,
                        ROLE : null,
                        ID_COMPTE : null,
                        ID_PROFILE : null
                    });
                    //noinspection JSUnresolvedVariable
                    $storage.OPENTESTTOKEN = data.token;

                    $http({
                        method: 'GET',
                        url: BASE_URL+'api/profile?token='+$storage.OPENTESTTOKEN
                    })
                        .success(function (data) {
                            //noinspection JSUnresolvedVariable
                            $storage.ROLE = data.role;
                            $storage.ID_COMPTE = data.id;
                        })
                        .error(function (data) {
                            return data;
                        });

                    return data;
                })
                .error(function (data) {
                    return data;
                });
        }
    }
});

function GetProfile($http,URL) {

}