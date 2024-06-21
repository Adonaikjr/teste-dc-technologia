<?php

namespace Tests\Feature;

use App\Models\Leads;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\LeadsFactory; // Import the factory
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LeadTest extends TestCase
{
    use DatabaseTransactions;
    public function test_CriarVariosLeads()
    {
        LeadsFactory::new()->count(100)->create(); // Corrected usage

        // Assert that 5 leads were created (modify assertions as needed)
        $this->assertCount(100, Leads::all());
    }
}
