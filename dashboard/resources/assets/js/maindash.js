$('.button-collapse').sideNav({
      menuWidth: 100, // Default is 300
      edge: 'left', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      draggable: true // Choose whether you can drag to open on touch screens
    }
  );

 $(document).ready(function(){
    $('.tooltipped').tooltip({delay: 50});
  });
//  var app = angular.module("amhostApp", ["ngRoute"]);
// app.config(function($routeProvider) {
//     $routeProvider
//     .when("/monitoring", {
//         templateUrl : "views/monitoring.htm"
//     })
//     .when("/Details", {
//         templateUrl : "views/Details.htm"
//     })
//     .when("/", {
//         templateUrl : "views/dashboard.htm"
//     })
//     .otherwise({
//         redirectTo : '/'
//     });
// });
$('.dropdown-button').dropdown({
    belowOrigin: true, 
    alignment: 'left', 
    inDuration: 200,
    outDuration: 150,
    constrain_width: true,
    hover: false, 
    gutter: 1
  });

dropdownMenu = $('.dropdown-menu');
dropdown = $('.dropdown');

dropdownMenu.hide();

dropdown.mousemove(function(){
    dropdownMenu.show();
});

dropdown.mouseout(function(){
    dropdownMenu.hide();
});