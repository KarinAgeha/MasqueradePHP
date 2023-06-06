# MasqueradePHP
Laravel's facade like system.  
# Notice
The system relies on Latte, a dependency autoinjection container.  
Don't forget to clone Latte when using this class.  
# Usage
```php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

class SampleClass {
    private SampleTwoClass $sample2class;
    public function __construct(SampleTwoClass $sample2class)
    {
        $this->sample2class = $sample2class;
    }

    public function hello_world()
    {
        $this->sample2class->safetySay('Hello, World!');
    }
}

class SampleTwoClass {
    public function safetySay(string $text)
    {
        echo htmlspecialchars($text);
    }
}

class StaticLikeClass extends Masquerade{
    public static function getIdentity(): string
    {
        return 'sample';
    }
}

$latte = Latte::Start()->entry(SampleClass::class, SampleClass::class)->entry(SampleTwoClass::class, SampleTwoClass::class);
$latte->lenientResolve();
$latte->alias('sample', SampleClass::class);
$latte->aliasLoad();
Masquerade::bootAnalyzer($latte);

StaticLikeClass::hello_world();
```
