angular.module('project_api', ["mes-directives"])
    .controller('getProjects', function($scope, $http) {
        $http.get('http://localhost:8000/api/admin/projects/')
            .then(function(reponse){
                $scope.allProjects = reponse.data;
                console.log($scope.allProjects);
            })
});