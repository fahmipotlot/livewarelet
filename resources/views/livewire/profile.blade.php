<div>
    <style>
        .link {
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                @if($user)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><a  wire:click.prevent="logout" class="link">Logout</a></td>
                    </tr>
                    <tr>
                        <td><b>Name</b></td>
                        <td>{{ $user->name }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Email</b></td>
                        <td>{{ $user->email }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Balance</b></td>
                        <td>{{ number_format($user->balance) }}</td>
                        <td></td>
                        <td>
                            <a data-bs-toggle="modal" class="link" data-bs-target="#modalTopup">Topup</a> ||
                            <a data-bs-toggle="modal" class="link" data-bs-target="#modalWithdraw">Withdraw</a>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Balance History</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Date</b></td>
                        <td><b>Type</b></td>
                        <td><b>Nominal</b></td>
                        <td><b>Reference</b></td>
                    </tr>
                    @foreach($user->transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at }}</td>
                            <td>{{ $transaction->type }}</td>
                            <td>{{ number_format($transaction->nominal) }}</td>
                            <td>{{ $transaction->reference }}</td>
                        </tr>
                    @endforeach

                    <!-- Modal Topup -->
                    <div wire:ignore.self class="modal fade" id="modalTopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTopupLabel">Top Up Balance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="nominal">Nominal</label>
                                            <input type="number" class="form-control" id="nominal" placeholder="Nominal" wire:model="nominal">
                                            @error('nominal') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" wire:click.prevent="topup() data-bs-dismiss="modal"">Top Up</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Withdraw -->
                    <div wire:ignore.self class="modal fade" id="modalWithdraw" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalWithdrawLabel">Withdraw Order</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="order_number">Order Number</label>
                                            <input type="text" class="form-control" id="order_number" placeholder="Order Number" wire:model="order_number">
                                            @error('order_number') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Nominal</label>
                                            <input type="number" class="form-control" id="amount" placeholder="Amount" wire:model="amount">
                                            @error('amount') <span class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" wire:click.prevent="withdraw() data-bs-dismiss="modal"">Withdraw</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                <tr>
                    <td>You must login first</td>
                    <td></td>
                    <td></td>
                    <td><a  wire:click.prevent="login" class="link">Login</a></td>
                </tr>
                @endif
            </table>      
        </div>
    </div>
</div>