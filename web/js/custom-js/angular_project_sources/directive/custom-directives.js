angular.module("mes-directives", [])
.directive("displayProjects", function() {

    //let route = $scope.laurent;
    return {
        restrict: "E",
        template: "Voici la valeur de routing : {{ laurent }}",
        //templateUrl: route,
        scope: {
            laurent: "@"
        }
    }
});
