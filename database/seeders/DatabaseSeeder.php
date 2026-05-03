<?php

namespace Database\Seeders;

use App\Models\ClassBooking;
use App\Models\GymClass;
use App\Models\Member;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Trainer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@fitlife.com'],
            [
                'name'     => 'Admin FitLife',
                'password' => Hash::make('password'),
            ]
        );
        // ── Membership Plans ──────────────────────────────────────────────
        $basic = MembershipPlan::create([
            'name'             => 'Basic',
            'description'      => 'Access to gym floor and basic equipment. Perfect for beginners.',
            'price'            => 150000,
            'duration_months'  => 1,
            'max_classes'      => 4,
            'personal_trainer' => false,
            'is_active'        => true,
        ]);

        $silver = MembershipPlan::create([
            'name'             => 'Silver',
            'description'      => 'Full gym access + 8 group classes per month.',
            'price'            => 300000,
            'duration_months'  => 1,
            'max_classes'      => 8,
            'personal_trainer' => false,
            'is_active'        => true,
        ]);

        $gold = MembershipPlan::create([
            'name'             => 'Gold',
            'description'      => 'Unlimited classes + 2 personal training sessions per month.',
            'price'            => 500000,
            'duration_months'  => 1,
            'max_classes'      => 0,
            'personal_trainer' => true,
            'is_active'        => true,
        ]);

        $platinum = MembershipPlan::create([
            'name'             => 'Platinum Annual',
            'description'      => 'Best value! Unlimited access, unlimited classes, weekly PT sessions.',
            'price'            => 4500000,
            'duration_months'  => 12,
            'max_classes'      => 0,
            'personal_trainer' => true,
            'is_active'        => true,
        ]);

        // ── Trainers ──────────────────────────────────────────────────────
        $trainer1 = Trainer::create([
            'first_name'     => 'Budi',
            'last_name'      => 'Santoso',
            'email'          => 'budi.santoso@fitlife.com',
            'phone'          => '081234567890',
            'specialization' => 'Strength & Conditioning',
            'bio'            => 'Certified strength coach with 8 years of experience. Specializes in powerlifting and functional fitness.',
            'is_active'      => true,
        ]);

        $trainer2 = Trainer::create([
            'first_name'     => 'Sari',
            'last_name'      => 'Dewi',
            'email'          => 'sari.dewi@fitlife.com',
            'phone'          => '081234567891',
            'specialization' => 'Yoga & Pilates',
            'bio'            => 'Certified yoga instructor with 5 years of experience. Passionate about mindfulness and flexibility.',
            'is_active'      => true,
        ]);

        $trainer3 = Trainer::create([
            'first_name'     => 'Andi',
            'last_name'      => 'Pratama',
            'email'          => 'andi.pratama@fitlife.com',
            'phone'          => '081234567892',
            'specialization' => 'Cardio & HIIT',
            'bio'            => 'Former national athlete. Expert in high-intensity interval training and cardiovascular fitness.',
            'is_active'      => true,
        ]);

        // ── Members ───────────────────────────────────────────────────────
        $members = [
            ['first_name' => 'Rizky',   'last_name' => 'Firmansyah', 'email' => 'rizky@email.com',   'phone' => '08111111111', 'gender' => 'male',   'status' => 'active'],
            ['first_name' => 'Putri',   'last_name' => 'Rahayu',     'email' => 'putri@email.com',   'phone' => '08111111112', 'gender' => 'female', 'status' => 'active'],
            ['first_name' => 'Dimas',   'last_name' => 'Kurniawan',  'email' => 'dimas@email.com',   'phone' => '08111111113', 'gender' => 'male',   'status' => 'active'],
            ['first_name' => 'Ayu',     'last_name' => 'Lestari',    'email' => 'ayu@email.com',     'phone' => '08111111114', 'gender' => 'female', 'status' => 'active'],
            ['first_name' => 'Fajar',   'last_name' => 'Nugroho',    'email' => 'fajar@email.com',   'phone' => '08111111115', 'gender' => 'male',   'status' => 'active'],
            ['first_name' => 'Indah',   'last_name' => 'Permata',    'email' => 'indah@email.com',   'phone' => '08111111116', 'gender' => 'female', 'status' => 'active'],
            ['first_name' => 'Hendra',  'last_name' => 'Wijaya',     'email' => 'hendra@email.com',  'phone' => '08111111117', 'gender' => 'male',   'status' => 'inactive'],
            ['first_name' => 'Melinda', 'last_name' => 'Sari',       'email' => 'melinda@email.com', 'phone' => '08111111118', 'gender' => 'female', 'status' => 'active'],
        ];

        $createdMembers = [];
        foreach ($members as $m) {
            $createdMembers[] = Member::create(array_merge($m, [
                'date_of_birth' => Carbon::now()->subYears(rand(20, 45))->subDays(rand(0, 365)),
                'address'       => 'Jl. Contoh No. ' . rand(1, 100) . ', Jakarta',
            ]));
        }

        // ── Memberships ───────────────────────────────────────────────────
        $plans = [$basic, $silver, $gold, $platinum];
        foreach ($createdMembers as $i => $member) {
            if ($member->status === 'inactive') continue;
            $plan      = $plans[$i % count($plans)];
            $startDate = Carbon::now()->subDays(rand(0, 20));
            $endDate   = $startDate->copy()->addMonths($plan->duration_months)->subDay();

            $membership = Membership::create([
                'member_id'  => $member->id,
                'plan_id'    => $plan->id,
                'start_date' => $startDate,
                'end_date'   => $endDate,
                'status'     => 'active',
            ]);

            Payment::create([
                'member_id'      => $member->id,
                'membership_id'  => $membership->id,
                'amount'         => $plan->price,
                'payment_method' => ['cash', 'credit_card', 'bank_transfer', 'e_wallet'][rand(0, 3)],
                'status'         => 'paid',
                'payment_date'   => $startDate,
            ]);
        }

        // ── Classes ───────────────────────────────────────────────────────
        $classData = [
            ['name' => 'Morning Yoga Flow',    'category' => 'Yoga',     'trainer' => $trainer2, 'room' => 'Studio A', 'duration' => 60],
            ['name' => 'HIIT Blast',           'category' => 'Cardio',   'trainer' => $trainer3, 'room' => 'Main Hall', 'duration' => 45],
            ['name' => 'Powerlifting Basics',  'category' => 'Strength', 'trainer' => $trainer1, 'room' => 'Weight Room', 'duration' => 75],
            ['name' => 'Pilates Core',         'category' => 'Pilates',  'trainer' => $trainer2, 'room' => 'Studio B', 'duration' => 50],
            ['name' => 'Cardio Kickboxing',    'category' => 'Cardio',   'trainer' => $trainer3, 'room' => 'Main Hall', 'duration' => 60],
            ['name' => 'Functional Fitness',   'category' => 'Strength', 'trainer' => $trainer1, 'room' => 'Weight Room', 'duration' => 60],
        ];

        $gymClasses = [];
        foreach ($classData as $idx => $cd) {
            $schedule = Carbon::now()->addDays($idx + 1)->setHour(7 + ($idx * 2))->setMinute(0);
            $gymClasses[] = GymClass::create([
                'trainer_id'       => $cd['trainer']->id,
                'name'             => $cd['name'],
                'category'         => $cd['category'],
                'schedule'         => $schedule,
                'duration_minutes' => $cd['duration'],
                'max_capacity'     => 15,
                'room'             => $cd['room'],
                'status'           => 'scheduled',
            ]);
        }

        // ── Class Bookings ────────────────────────────────────────────────
        foreach ($gymClasses as $gymClass) {
            $shuffled = collect($createdMembers)->where('status', 'active')->shuffle()->take(rand(3, 6));
            foreach ($shuffled as $member) {
                ClassBooking::firstOrCreate([
                    'member_id' => $member->id,
                    'class_id'  => $gymClass->id,
                ], ['status' => 'booked']);
            }
        }
    }
}
