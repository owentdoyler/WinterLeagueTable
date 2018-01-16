angular.module('app1', ['angularFileUpload'])
.controller('AppController', function($scope, FileUploader) {

    $scope.uploadedFile = {ready: false, name: ""}

    $scope.uploader = new FileUploader({
        url: 'scripts/php/file_upload/upload.php',
        queueLimit: 1
    });

    $scope.uploader.onProgressAll = function(progress) {
        $scope.uploadedFile.ready = true;
        console.log($scope.uploadedFile.ready);
    };
});