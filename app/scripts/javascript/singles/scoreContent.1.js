// Code goes here
var app = angular.module("singlesApp", ["ngAnimate"]);

app.controller("MyCtrl", function($scope, $http) {
  $http
    .get("../scripts/php/singles/winter_league_singles_scores.1.php")
    .then(function(response) {
      $scope.players = response.data;
    });

  $scope.show = true;
  $scope.test = "world";
  $scope.weekShown = -1;
  $scope.teamShown = -1;

  if (window.matchMedia("screen and (max-width: 500px)").matches) {
    $scope.showTable = false;
  } else {
    $scope.showTable = true;
  }

  $scope.showDescription = function() {
    $scope.showTable = !$scope.showTable;
  };

  $scope.setWeekShown = function(weekIndex) {
    $scope.weekShown = weekIndex;
  };

  $scope.setTeamShown = function(teamIndex) {
    $scope.teamShown = teamIndex;
  };

  $scope.teamRowClicked = function(index) {
    if ($scope.teamShown == index) {
      $scope.setWeekShown(-1);
      $scope.setTeamShown(-1);
    } else {
      $scope.setTeamShown(index);
      $scope.setWeekShown(-1);
    }
  };

  $scope.weekRowClicked = function(index) {
    if ($scope.weekShown == index) {
      $scope.setWeekShown(-1);
    } else {
      $scope.setWeekShown(index);
    }
  };

  $scope.even = function(num) {
    return num % 2 === 0;
  };
});
