@extends('dashboard.layouts.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="p-4 rounded shadow-sm bg-light">
                <form id="updateCompanyProfileForm" action="{{ route('updateCompany') }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="text-center mb-4">
                        <div class="position-relative">
                            <img 
                                id="avatarImage"
                                src="{{ !empty($company->logoo) ? Storage::url($company->logoo) : asset('vertical/assets/images/avatars/11.png') }}" 
                                alt="Avatar" 
                                class="rounded-circle img-fluid shadow-sm"
                                style="width: 150px; height: 150px; object-fit: cover;"
                            >
                            <label for="logoo" class="position-absolute bottom-0 end-0 mb-2 me-2 p-2 bg-primary text-white rounded-circle cursor-pointer shadow-sm">
                                <i class="bi bi-pencil"></i>
                            </label>
                            <input type="file" name="logoo" id="logoo" accept="image/*" class="d-none">
                        </div>
                    </div>

                    <!-- Name Section -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Perusahaan</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name"  
                            class="form-control" 
                            value="{{ old('name', $company->name ?? '') }}"
                        >
                        @error('name')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Section -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">No Telepon Perusahaan</label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone"  
                            class="form-control" 
                            value="{{ old('phone', $company->phone ?? '') }}"
                        >
                        @error('phone')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Section -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Perusahaan</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"  
                            class="form-control" 
                            value="{{ old('email', $company->email ?? '') }}"
                        >
                        @error('email')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address Section -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Perusahaan</label>
                        <input 
                            type="text" 
                            id="address" 
                            name="address"
                            class="form-control" 
                            value="{{ old('address', $company->address ?? '') }}"
                        >
                        @error('address')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description Section -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Perusahaan</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            class="form-control"
                        >{{ old('description', $company->description ?? '') }}</textarea>
                        @error('description')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Latitude Section -->
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input 
                            type="text" 
                            id="latitude" 
                            name="latitude" 
                            class="form-control"
                            value="{{ old('latitude', $company->latitude ?? '') }}"
                        >
                        @error('latitude')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Longitude Section -->
                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input 
                            type="text" 
                            id="longitude" 
                            name="longitude" 
                            class="form-control"
                            value="{{ old('longitude', $company->longitude ?? '') }}"
                        >
                        @error('longitude')
                            <p class="text-danger small mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Update Button -->
                    <div class="text-center mt-4">
                        <button 
                            type="submit" 
                            class="btn btn-primary w-100 py-2"
                        >
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
