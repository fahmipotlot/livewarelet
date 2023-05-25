<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class Profile extends Component
{
    public $nominal, $order_number, $amount;

    public function render()
    {
        $user = auth()->user();
        return view('livewire.profile', [
            'user' => $user
        ]);
    }

    public function logout()
    {
        \Auth::logout();

        return redirect()->to('/');
    }

    public function login()
    {
        return redirect()->to('/');
    }

    private function resetInputFields(){
        $this->nominal = '';
        $this->order_number = '';
        $this->amount = '';
    }

    public function topup()
    {
        $validatedDate = $this->validate([
            'nominal' => 'required|numeric',
        ]);

        $user_id = auth()->user()->id;

        $user = User::find($user_id);

        $balance = $user->balance + $this->nominal;

        $trx = new Transaction([
            'type' => 'deposit',
            'nominal' => $this->nominal,
        ]);

        try {
            $user->transactions()->save($trx);
    
            $user->update(['balance' => $balance]);
    
            session()->flash('message', 'Toup Successfully.');
    
            $this->resetInputFields();

            return redirect()->to('/profile');
        } catch (\Exception $e) {
            session()->flash('error', 'Toup Failed');
        }
    }

    public function withdraw()
    {
        $user_id = auth()->user()->id;

        $user = User::find($user_id);
        
        $validatedDate = $this->validate([
            'order_number' => 'required',
            'amount' => 'required|numeric|max:'.$user->balance.'',
        ]);

        $balance = $user->balance - $this->amount;

        $trx = new Transaction([
            'type' => 'withdrawal',
            'nominal' => $this->amount,
            'reference' => $this->order_number,
        ]);

        try {
            $token = base64_encode($user->name);
            $data = [
                'order_number' => $this->order_number,
                'amount' => $this->amount
            ];

            $this->interationWithdrawal($token, $data);

            $user->transactions()->save($trx);
    
            $user->update(['balance' => $balance]);
    
            session()->flash('message', 'withdrawal Successfully.');
    
            $this->resetInputFields();

            return redirect()->to('/profile');
        } catch (\Exception $e) {
            session()->flash('error', 'withdrawal Failed');
        }
    }

    public function interationWithdrawal($token, $data)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->post('https://webhook.site/a317920b-0f70-4c23-98dd-5e3751fd131a', [
            'order_id' => $data['order_number'],
            'amount' => $data['amount'],
        ]);

        $jsonData = $response->json();

        // log for response from API
        \Log::info($jsonData);
    }
}
