<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use Hyn\Tenancy\Contracts\Repositories\CustomerRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Customer;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\Hash;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a tenant with the provided name and email address e.g. php artisan tenant:create boise boise@example.com';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        if ($this->tenantExists($email)) {
            $this->error("A tenant with email '{$email}' already exists.");
            return;
        }
        $hostname = $this->registerTenant($name, $email);
        app(Environment::class)->hostname($hostname);
        $this->info("Tenant '{$name}' is created and is now accessible at {$hostname->fqdn}");
        $this->info("Admin {$email} can log in using password {$password}");
    }

    private function tenantExists($email)
    {
        return User::where('email', $email)->exists();
        // 1 Feb 2019 - no customer table is needed
        // return Customer::where('name', $name)->orWhere('email', $email)->exists();
    }
    private function registerTenant($name, $email)
    {
        // 1 Feb 2019 - no customer table is needed
        // create a customer
        // $customer = new Customer;
        // $customer->name = $name;
        // $customer->email = $email;
        // app(CustomerRepository::class)->create($customer);
        // associate the customer with a website
        $website = new Website;
        // $website->customer()->associate($customer);
        app(WebsiteRepository::class)->create($website);
        // associate the website with a hostname
        $hostname = new Hostname;
        $baseUrl = config('app.url_base');
        $hostname->fqdn = "{$name}.{$baseUrl}";
        // $hostname->customer()->associate($customer);
        app(HostnameRepository::class)->attach($hostname, $website);
        // we'll create a random secure password for our to-be admin
        $password = str_random();
        $this->addAdmin($name, $email, $password, $hostname,$website);
        return $hostname;
    }
    private function addAdmin($name, $email, $password, $hostname, $website)
    {
        $tenancy = app(Environment::class);
        $tenancy->tenant($website); // switches the tenant and reconfigures the app

        $admin = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password), 'hostname_id' => $hostname->id]);
        $admin->guard_name = 'web';
        $admin->assignRole('admin');
        return $admin;
    }
}