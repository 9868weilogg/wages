<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use Hyn\Tenancy\Contracts\Repositories\CustomerRepository;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Models\Customer;
use Hyn\Tenancy\Models\Website;
use Illuminate\Support\Facades\Config;

class DeleteTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:delete {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes a tenant of the provided email. Only available on the local environment e.g. php artisan tenant:delete boise@example.com';

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
        // because this is a destructive command, we'll only allow to run this command
        // if you are on the local environment
        if (!app()->isLocal()) {
            $this->error('This command is only avilable on the local environment.');
            return;
        }
        $email = $this->argument('email');
        $this->deleteTenant($email);
    }

    private function deleteTenant($email)
    {
        if ($user = User::where('email', $email)->with(['hostname'])->firstOrFail()) {
            $hostname = $user->hostname->first();
            $website = Website::find($hostname->website_id);
            app(HostnameRepository::class)->delete($hostname, true);
            app(WebsiteRepository::class)->delete($website, true);
            $this->info("Tenant {$email} successfully deleted.");
        }
    }
}
