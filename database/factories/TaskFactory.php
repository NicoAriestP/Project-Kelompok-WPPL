<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Enum\Task\PriorityType;
use App\Enum\Task\EffortType;
use App\Enum\Task\StatusType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TaskFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estimatedTimeDummy = [
            '1 Hari',
            '2 Hari',
            '3 Hari',
            '4 Hari',
            '5 Hari',
        ];

        // Generate a random index within the range of the array
        $randomIndex = rand(0, count($estimatedTimeDummy) - 1);

        // Get the random word from the array
        $randomEstimation = $estimatedTimeDummy[$randomIndex];

        return [
            'category_id' => rand(1, Category::count()),
            'pic_id' => rand(1, User::count()),
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->text(100),
            'due_at' => $this->faker->dateTimeBetween('-1 week', '+1 month'), 
            'finished_at' => $this->faker->dateTimeBetween('0 week', '+1 week'),
            'estimation' => $randomEstimation,
            'priority' => $this->faker->randomElement([
                PriorityType::LOW, 
                PriorityType::NORMAL, 
                PriorityType::HIGH, 
                PriorityType::URGENT, 
            ]),
            'effort' => $this->faker->randomElement([
                EffortType::EASY,  
                EffortType::MEDIUM,  
                EffortType::HARD,  
            ]),
            'status' => $this->faker->randomElement([
                StatusType::OPEN,  
                StatusType::IN_PROGRESS,  
                StatusType::RESOLVED,  
                StatusType::CLOSED,  
                StatusType::REOPEN,  
            ])
        ];
    }
}
