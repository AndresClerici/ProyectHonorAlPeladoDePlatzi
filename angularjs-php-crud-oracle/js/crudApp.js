var app = angular.module('crudApp', ['datatables']);
app.controller('crudController', function($scope, $http){	

	$scope.success = false;

	$scope.error = false;

	$scope.fetchData = function(){
		$http.get('fetch_data.php').then(
		function successCallback(response){
			$scope.facturaData = response.data;			
			console.log(response);
		}, function errorCallback(response) {
			console.log('FAILURE');
		});
	};

	$scope.openModal = function(){
		var modal_popup = angular.element('#crudmodal');
		modal_popup.modal('show');
	};

	$scope.closeModal = function(){
		var modal_popup = angular.element('#crudmodal');
		modal_popup.modal('hide');
	};

	$scope.addData = function(){
		$scope.modalTitle = 'Add Data';
		$scope.submit_button = 'Insert';
		$scope.openModal();
	};

	$scope.submitForm = function(){
		$http({
			method:"POST",
			url:"insert.php",
			data:{'cod_empresa':$scope.cod_empresa,
				  'cod_sucursal':$scope.cod_sucursal,
				  'tipo_comprobante':$scope.tipo_comprobante,
				  'ser_comprobante':$scope.ser_comprobante,
				  'nro_comprobante':$scope.nro_comprobante,
				  'action':$scope.submit_button,
				  'id':$scope.hidden_id}
		}).then(function successCallback(response){
			if(response.data.error != '')
			{
				$scope.success = false;
				$scope.error = true;
				$scope.errorMessage = response.data.error;
			}
			else
			{
				$scope.success = true;
				$scope.error = false;
				$scope.successMessage = response.data.message;
				$scope.form_data = {};
				$scope.closeModal();
				$scope.fetchData();
			}
		}, function errorCallback(response) {
			console.log('FAILURE');
		});

		console.log($scope.cod_empresa + $scope.cod_sucursal + $scope.tipo_comprobante + $scope.ser_comprobante + 
			$scope.nro_comprobante + $scope.submit_button + $scope.hidden_id);
	};

	$scope.fetchSingleData = function(id){
		$http({
			method:"POST",
			url:"insert.php",
			data:{'id':id,
				  'action':'fetch_single_data'}
		}).then(function successCallback(response){
			$scope.cod_empresa = response.data.cod_empresa;
			$scope.cod_sucursal = response.data.cod_sucursal;
			$scope.tipo_comprobante = response.data.tipo_comprobante;
			$scope.ser_comprobante = response.data.ser_comprobante;
			$scope.nro_comprobante = response.data.nro_comprobante;
			$scope.hidden_id = id;
			$scope.modalTitle = 'Edit Data';
			$scope.submit_button = 'Edit';
			$scope.openModal();
		}, function errorCallback(response) {
			console.log('FAILURE');
		});
	};

	$scope.deleteData = function(id){
		if(confirm("Are you sure you want to remove it?"))
		{
			$http({
				method:"POST",
				url:"insert.php",
				data:{'id':id, 
					  'action':'Delete'}
			}).then(function successCallback(response){
				$scope.success = true;
				$scope.error = false;
				$scope.successMessage = response.data.message;
				$scope.fetchData();
			}, function errorCallback(response) {
				console.log('FAILURE2');
			});	
		}
	};
});