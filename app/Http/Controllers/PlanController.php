<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Display a listing of the plans (admin).
     */
    public function index()
    {
        $plans = Plan::orderByDesc('is_active')->orderBy('price')->paginate(10);
        return view('admin.plans', compact('plans'));
    }

    /**
     * Show the form for creating a new plan (admin).
     */
    public function create()
    {
        return view('admin.plan-create');
    }

    /**
     * Store a newly created plan in storage (admin).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'request_limit' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
        Plan::create($data);
        return redirect()->route('admin.plans.index')->with('success', __('admin.plan_created'));
    }

    /**
     * Show the form for editing the specified plan (admin).
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plan-edit', compact('plan'));
    }

    /**
     * Update the specified plan in storage (admin).
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'request_limit' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
        $plan->update($data);
        return redirect()->route('admin.plans.index')->with('success', __('admin.plan_updated'));
    }

    /**
     * Remove the specified plan from storage (admin).
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', __('admin.plan_deleted'));
    }

    /**
     * Display a listing of the plans for users.
     */
    public function userIndex()
    {
        $plans = Plan::where('is_active', true)->orderBy('price')->paginate(8);
        return view('profile.plans', compact('plans'));
    }

    /**
     * Purchase a plan (user).
     */
    public function purchase(Request $request, Plan $plan)
    {
        $user = auth()->user();
        
        // Bepul tarif uchun maxsus tekshirish
        if ($plan->price == 0) {
            // Bepul tarifni 1 oyda 1 marta olish mumkin
            $lastFreePlanPurchase = $user->transactions()
                ->where('type', 'purchase')
                ->where('plan_id', $plan->id)
                ->where('created_at', '>=', now()->subMonth())
                ->first();
                
            if ($lastFreePlanPurchase) {
                return redirect()->back()->with('error', __('admin.free_plan_monthly_limit'));
            }
        } else {
            // Pulli tariflar uchun balans tekshirish
            if ($user->balance < $plan->price) {
                return redirect()->back()->with('error', __('admin.insufficient_balance'));
            }
        }
        
        // Create transaction
        $user->transactions()->create([
            'amount' => -$plan->price,
            'type' => 'purchase',
            'description' => "Plan purchased: {$plan->name}",
            'plan_id' => $plan->id,
        ]);
        
        // Update user balance and request limit
        if ($plan->price > 0) {
            $user->balance -= $plan->price;
        }
        // Yangi limit qoldiq limit ustiga qo'shiladi
        $user->request_limit += $plan->request_limit;
        // requests_used o'zgarishsiz qoladi
        $user->plan_id = $plan->id;
        $user->save();
        
        return redirect()->route('plans.index')->with('success', __('admin.plan_purchased'));
    }
}
