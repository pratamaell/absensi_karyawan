document.addEventListener('DOMContentLoaded', function() {
        const cameraInput = document.getElementById('cameraInput');
        const openCamera = document.getElementById('openCamera');
        const preview = document.getElementById('preview');
        const submitBtn = document.getElementById('submitBtn');
        const locationStatus = document.getElementById('locationStatus');
        let locationValid = false;

        // Handle camera button
        openCamera.addEventListener('click', function() {
            cameraInput.click();
        });

        // Preview image
        cameraInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(e.target.files[0]);
                checkSubmitEnabled();
            }
        });

        // Get user location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Office coordinates (example)
                        const officeLat = -6.123456; // Replace with actual office coordinates
                        const officeLng = 106.123456;
                        
                        // Calculate distance using Haversine formula
                        const distance = calculateDistance(lat, lng, officeLat, officeLng);
                        
                        document.getElementById('lat').value = lat;
                        document.getElementById('lng').value = lng;
                        
                        if (distance <= 0.5) { // 0.5 km = 500m
                            locationStatus.innerHTML = '<i class="fas fa-check-circle text-success me-2"></i>Lokasi tervalidasi';
                            locationValid = true;
                        } else {
                            locationStatus.innerHTML = '<i class="fas fa-times-circle text-danger me-2"></i>Anda harus berada dalam radius 500m dari kantor';
                            locationValid = false;
                        }
                        checkSubmitEnabled();
                    },
                    function(error) {
                        locationStatus.innerHTML = '<i class="fas fa-exclamation-circle text-danger me-2"></i>Gagal mendeteksi lokasi. Pastikan GPS aktif.';
                        locationValid = false;
                        checkSubmitEnabled();
                    }
                );
            }
        }

        // Calculate distance between two points
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Earth's radius in km
            const dLat = toRad(lat2-lat1);
            const dLon = toRad(lon2-lon1);
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                     Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * 
                     Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        function toRad(value) {
            return value * Math.PI / 180;
        }

        function checkSubmitEnabled() {
            submitBtn.disabled = !(locationValid && cameraInput.files.length > 0);
        }

        // Initialize location check
        getLocation();
    });