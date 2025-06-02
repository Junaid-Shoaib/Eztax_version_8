@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-1 shadow-sm">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <!-- Dashboard Content Starts Here -->
                                <!-- Subtitle -->
                                <p class="text-muted mb-3">Overview of your notices</p>

                                <!-- Progress Box -->
                                <div class="card border-1 p-3 rounded shadow-sm mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong>Overall Progress</strong>
                                            <i class="bi bi-info-circle ms-1" title="Overall task completion status"></i>
                                        </div>
                                        <div class="fw-bold text-dark">{{ $progress }}%</div>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar" style="width: {{ $progress }}%; background-color: #b36aff;"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2 small">
                                        <span class="text-muted">● Completed: {{ $notice_Comp_count }}</span>
                                        <span class="text-muted">● Pending: {{ $notice_Pend_count }}</span>
                                    </div>
                                </div>

                                <!-- Stats Cards -->
                                <div class="row g-3">
                                    <!-- Total Clients -->
                                    <div class="col-md-3">
                                        <div class="card p-3 border-1 shadow-sm rounded">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <div class="fw-semibold">Total Clients</div>
                                                <div class="bg-light rounded-circle p-2">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                            <h4 class="mb-1">{{ $total_client }}</h4>
                                            <div class="text-muted small">Registered clients in the system</div>
                                        </div>
                                    </div>

                                    <!-- Total Notices -->
                                    <div class="col-md-3">
                                        <div class="card p-3 border-1 shadow-sm rounded">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <div class="fw-semibold">Total Notices</div>
                                                <div class="bg-light rounded-circle p-2" style="background-color: #f8e8ff;">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </div>
                                            </div>
                                            <h4 class="mb-1">{{ $total_client }}</h4>
                                            <div class="text-muted small">All notices in the system</div>
                                        </div>
                                    </div>

                                    <!-- Pending Notices -->
                                    <div class="col-md-3">
                                        <div class="card p-3 border-1 shadow-sm rounded">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <div class="fw-semibold">Pending Notices</div>
                                                <div class="bg-light rounded-circle p-2" style="background-color: #fff8e6;">
                                                    <i class="bi bi-clock-history"></i>
                                                </div>
                                            </div>
                                            <h4 class="mb-1">{{ $notice_Pend_count }}</h4>
                                            <div class="text-muted small">Notices requiring action</div>
                                        </div>
                                    </div>

                                    <!-- Completed Notices -->
                                    <div class="col-md-3">
                                        <div class="card p-3 border-1 shadow-sm rounded">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <div class="fw-semibold">Completed Notices</div>
                                                <div class="bg-light rounded-circle p-2" style="background-color: #e8fff1;">
                                                    <i class="bi bi-check-circle"></i>
                                                </div>
                                            </div>
                                            <h4 class="mb-1">{{ $notice_Comp_count }}</h4>
                                            <div class="text-muted small">Successfully resolved notices</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Dashboard Content Ends Here -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection