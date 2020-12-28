<?php declare(strict_types=1);

namespace Novuso\System\Test\Utility;

use Novuso\System\Test\Resources\TestStringObject;
use Novuso\System\Test\TestCase\VirtualFileSystem;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * Trait TestDataProvider
 */
trait TestDataProvider
{
    use VirtualFileSystem;

    public function validScalarProvider(): array
    {
        return [
            ['string'],
            [3.14],
            [42],
            [true]
        ];
    }

    public function invalidScalarProvider(): array
    {
        return [
            [null],
            [new \StdClass()]
        ];
    }

    public function validBoolProvider(): array
    {
        return [
            [true],
            [false]
        ];
    }

    public function invalidBoolProvider(): array
    {
        return [
            [1],
            [null]
        ];
    }

    public function validFloatProvider(): array
    {
        return [
            [3.14],
            [-0.000012],
            [1.0]
        ];
    }

    public function invalidFloatProvider(): array
    {
        return [
            ['3.14'],
            [42]
        ];
    }

    public function validIntProvider(): array
    {
        return [
            [0],
            [0b101001],
            [0xff],
            [0700],
            [-100]
        ];
    }

    public function invalidIntProvider(): array
    {
        return [
            ['42'],
            ['101001'],
            [1.0]
        ];
    }

    public function validStringProvider(): array
    {
        return [
            [''],
            ['foo']
        ];
    }

    public function invalidStringProvider(): array
    {
        return [
            [null]
        ];
    }

    public function validArrayProvider(): array
    {
        return [
            [['foo', 'bar', 'baz']],
            [[]]
        ];
    }

    public function invalidArrayProvider(): array
    {
        return [
            [null],
            [new \ArrayObject()]
        ];
    }

    public function validObjectProvider(): array
    {
        return [
            [new \StdClass()]
        ];
    }

    public function invalidObjectProvider(): array
    {
        return [
            [null],
            [[]]
        ];
    }

    public function validCallableProvider(): array
    {
        return [
            [function () {}],
            ['array_merge'],
            [[new \DateTime(), 'getTimestamp']]
        ];
    }

    public function invalidCallableProvider(): array
    {
        return [
            [null],
            [new \DateTime()]
        ];
    }

    public function validNullProvider(): array
    {
        return [
            [null]
        ];
    }

    public function invalidNullProvider(): array
    {
        return [
            [false],
            ['']
        ];
    }

    public function validNotNullProvider(): array
    {
        return [
            [false],
            ['']
        ];
    }

    public function invalidNotNullProvider(): array
    {
        return [
            [null]
        ];
    }

    public function validTrueProvider(): array
    {
        return [
            [true]
        ];
    }

    public function invalidTrueProvider(): array
    {
        return [
            [false]
        ];
    }

    public function validFalseProvider(): array
    {
        return [
            [false]
        ];
    }

    public function invalidFalseProvider(): array
    {
        return [
            [true]
        ];
    }

    public function validEmptyProvider(): array
    {
        return [
            [''],
            [0],
            [0.0],
            ['0'],
            [null],
            [false],
            [[]]
        ];
    }

    public function invalidEmptyProvider(): array
    {
        return [
            [' '],
            [1],
            [1.0],
            ['1'],
            [function () {}],
            [true],
            [[0]],
            [new \ArrayObject()]
        ];
    }

    public function validNotEmptyProvider(): array
    {
        return [
            [' '],
            [1],
            [1.0],
            ['1'],
            [function () {}],
            [true],
            [[0]],
            [new \ArrayObject()]
        ];
    }

    public function invalidNotEmptyProvider(): array
    {
        return [
            [''],
            [0],
            [0.0],
            ['0'],
            [null],
            [false],
            [[]]
        ];
    }

    public function validBlankProvider(): array
    {
        return [
            [null],
            [''],
            [' '],
            [false],
            [new TestStringObject('')]
        ];
    }

    public function invalidBlankProvider(): array
    {
        return [
            ['value'],
            [true],
            [10],
            [1.17],
            [new TestStringObject('value')],
            [[]]
        ];
    }

    public function validNotBlankProvider(): array
    {
        return [
            ['value'],
            [true],
            [10],
            [1.17],
            [new TestStringObject('value')]
        ];
    }

    public function invalidNotBlankProvider(): array
    {
        return [
            [null],
            [''],
            [' '],
            [false],
            [new TestStringObject('')],
            [[]]
        ];
    }

    public function validAlphaProvider(): array
    {
        return [
            ['YjsZmHXHSxycLlZc'],
            ['uFzzkqBzWalPvztM'],
            ['aBAozPKgQfPIOZhQ'],
            ['kTotDhmqsfIJKxsC']
        ];
    }

    public function invalidAlphaProvider(): array
    {
        return [
            ['gq4XRHPx3zLqiFYj'],
            ['uAZ25RGjlgwg5kCY'],
            ['6cWxSYr0YWn5Matn'],
            ['G9i6rA87spb1RlEu'],
            [[]]
        ];
    }

    public function validAlnumProvider(): array
    {
        return [
            ['gq4XRHPx3zLqiFYj'],
            ['uAZ25RGjlgwg5kCY'],
            ['6cWxSYr0YWn5Matn'],
            ['G9i6rA87spb1RlEu']
        ];
    }

    public function invalidAlnumProvider(): array
    {
        return [
            ['YjzRUhM__Aib_WnQ'],
            ['MRhp-R_AnsQEyBCp'],
            ['kaP-ps_fIn-qibPu'],
            ['Pya-k-Svxf-RgAIN'],
            [[]]
        ];
    }

    public function validAlphaDashProvider(): array
    {
        return [
            ['YjzRUhM__Aib_WnQ'],
            ['MRhp-R_AnsQEyBCp'],
            ['kaP-ps_fIn-qibPu'],
            ['Pya-k-Svxf-RgAIN']
        ];
    }

    public function invalidAlphaDashProvider(): array
    {
        return [
            ['Lx7lDu-9oL0u-dsg'],
            ['_7RtK6U1HjU_qk4n'],
            ['C-3geaSMz9ySjm8_'],
            ['fV54_j-1Qheh0Ine'],
            [[]]
        ];
    }

    public function validAlnumDashProvider(): array
    {
        return [
            ['Lx7lDu-9oL0u-dsg'],
            ['_7RtK6U1HjU_qk4n'],
            ['C-3geaSMz9ySjm8_'],
            ['fV54_j-1Qheh0Ine']
        ];
    }

    public function invalidAlnumDashProvider(): array
    {
        return [
            ['U&36wu@@FO$vV7zy'],
            ['JBNKxkjs@8VgQFfk'],
            ['d%#3rKh77UFpLrsT'],
            ['jrKh4g^Pldz2aqc#'],
            [[]]
        ];
    }

    public function validDigitsProvider(): array
    {
        return [
            ['0576707396293939'],
            ['4120922250624932'],
            ['6363135058088673'],
            ['0021057296675399']
        ];
    }

    public function invalidDigitsProvider(): array
    {
        return [
            ['gq4XRHPx3zLqiFYj'],
            ['uAZ25RGjlgwg5kCY'],
            ['6cWxSYr0YWn5Matn'],
            ['G9i6rA87spb1RlEu'],
            [[]]
        ];
    }

    public function validNumericProvider(): array
    {
        return [
            [42],
            [3.14],
            [0x446164],
            [0b10001000110000101100100],
            ['42'],
            ['3.14'],
            ['0777'],
            ['+0123.45e6'],
            ['-0123.45e6']
        ];
    }

    public function invalidNumericProvider(): array
    {
        return [
            ['U&36wu@@FO$vV7zy'],
            ['JBNKxkjs@8VgQFfk'],
            ['d%#3rKh77UFpLrsT'],
            ['jrKh4g^Pldz2aqc#'],
            [[]]
        ];
    }

    public function validEmailProvider(): array
    {
        return [
            ['email@example.com'],
            ['firstname.lastname@example.com'],
            ['email@subdomain.example.com'],
            ['firstname+lastname@example.com'],
            ['"email"@example.com'],
            ['1234567890@example.com'],
            ['email@example-one.com'],
            ['_______@example.com'],
            ['email@example.name'],
            ['email@example.museum'],
            ['email@example.co.jp']
        ];
    }

    public function invalidEmailProvider(): array
    {
        return [
            ['plainaddress'],
            ['#@%^%#$@#$@#.com'],
            ['@example.com'],
            ['Joe Smith <email@example.com>'],
            ['email.example.com'],
            ['email@example@example.com'],
            ['.email@example.com'],
            ['email.@example.com'],
            ['email..email@example.com'],
            ['email@example.com (Joe Smith)'],
            ['email@example'],
            ['email@-example.com'],
            ['email@example..com'],
            ['Abc..123@example.com'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validIpAddressProvider(): array
    {
        return [
            ['155.217.46.237'],
            ['12.177.186.9'],
            ['162.118.58.122'],
            ['138.182.76.252'],
            ['FEDC:BA98:7654:3210:FEDC:BA98:7654:3210'],
            ['1080::8:800:200C:417A'],
            ['FF01::101'],
            ['::1']
        ];
    }

    public function invalidIpAddressProvider(): array
    {
        return [
            ['155.217.461.237'],
            ['12.177.186.9.1'],
            ['162.118.122'],
            ['138.182.76.257'],
            ['02001:0000:1234:0000:0000:C1C0:ABCD:0876'],
            ['3ffe:0b00:0000:0001:0000:0000:000a'],
            ['3ffe:b00::1::a'],
            ['1111:2222:3333:4444::5555:'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validIpV4AddressProvider(): array
    {
        return [
            ['155.217.46.237'],
            ['12.177.186.9'],
            ['162.118.58.122'],
            ['138.182.76.252']
        ];
    }

    public function invalidIpV4AddressProvider(): array
    {
        return [
            ['155.217.461.237'],
            ['12.177.186.9.1'],
            ['162.118.122'],
            ['138.182.76.257'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validIpV6AddressProvider(): array
    {
        return [
            ['FEDC:BA98:7654:3210:FEDC:BA98:7654:3210'],
            ['1080::8:800:200C:417A'],
            ['FF01::101'],
            ['::1']
        ];
    }

    public function invalidIpV6AddressProvider(): array
    {
        return [
            ['02001:0000:1234:0000:0000:C1C0:ABCD:0876'],
            ['3ffe:0b00:0000:0001:0000:0000:000a'],
            ['3ffe:b00::1::a'],
            ['1111:2222:3333:4444::5555:'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validUriProvider(): array
    {
        return [
            ['a:b'],
            ['foo://user@'],
            ['http://www.google.com'],
            ['https://domain.com:10082/foo/bar?query'],
            ['mailto:smith@example.com'],
            ['http://a_.!~*\'(-)U1HYn0%25%26:secret;:&=+$,ddd@www.me.com'],
            ['http://[FEDC:BA98:7654:3210:FEDC:BA98:7654:3210]:80/index.html'],
            ['http://[1080::8:800:200C:417A]/path'],
            ['http://[::192.9.5.5]/ipng'],
            ['http://[::FFFF:129.144.52.38]:80/index.html'],
            ['http://[2620:0:1cfe:face:b00c::3]/'],
            ['http://[vf.some-future+ip]'],
            ['http://foo#frag'],
            ['ftp://user:pass@example.org/'],
            ['http://1.1.1.1/'],
            ['http://[::1]/'],
            ['file:/'],
            ['http:///'],
            ['http:::/foo'],
            ['news:comp.infosystems.www.servers.unix'],
            ['tel:+1-816-555-1212'],
            ['urn:oasis:names:specification:docbook:dtd:xml:4.1.2'],
            ['urn:uuid:f81d4fae-7dec-11d0-a765-00a0c91e6bf6']
        ];
    }

    public function invalidUriProvider(): array
    {
        return [
            [''],
            ['//missing-scheme'],
            ['https://%@domain/path'],
            ['http://[3ffe:b00::1::a]'],
            ['https://do[main].com'],
            ['http://domain/p%th'],
            ['file:///etc?foo=[a]'],
            ['uri:foo:bar#[baz]'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validUrnProvider(): array
    {
        return [
            ['urn:cts:greekLit:tlg0012.tlg001.perseus-eng2'],
            ['URN:ISBN:978-1-491-90501-2'],
            ['urn:oasis:names:tc:docbook:dtd:xml:docbook:5.0b1'],
            ['urn:uuid:0977c273-5aac-403b-be23-1a0838e7940a']
        ];
    }

    public function invalidUrnProvider(): array
    {
        return [
            ['urn:loc.gov:books'],
            ['urn:urn:foo-invalid-namespace'],
            ['urn:example:reserved#characters'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validUuidProvider(): array
    {
        return [
            ['{5dd64499-0193-4753-8b6e-8286eb2d60b1}'],
            ['urn:uuid:5867eca3-874b-480f-a3a7-c6ea442a032a'],
            ['4df15ab0-d31f-11e4-93ba-765da632ca19'],
            ['014c5243-37e2-4463-a6b1-32a986565d19'],
            ['f18543a1-2b6d-36a5-b229-90c8fec28a35'],
            ['b2e4bc61-8cd1-5a49-b154-a449e6165f13']
        ];
    }

    public function invalidUuidProvider(): array
    {
        return [
            ['{5dd64499-0193-4753-8b6e82-86eb2d60b1}'],
            ['urn:uuid:5867eca3-874b-480f-a3a7-c6ea442a032'],
            ['4df15ab0-d31f-11e4-93ba-765dg632ca19'],
            ['014c5243-37e2-44-63-a6b1-32a986565d19'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validTimezoneProvider(): array
    {
        return [
            ['America/Chicago'],
            ['America/Jamaica'],
            ['Europe/Madrid'],
            ['Pacific/Pago_Pago']
        ];
    }

    public function invalidTimezoneProvider(): array
    {
        return [
            [new \DateTimeZone('+00:00')],
            ['America/San_Antonio'],
            ['America/Tiajuana'],
            ['Central'],
            ['United'],
            ['Asia/Bollywood'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validJsonProvider(): array
    {
        return [
            ['null'],
            ['{"foo":"bar"}'],
            ['["list","of","items"]']
        ];
    }

    public function invalidJsonProvider(): array
    {
        return [
            ['["list","of",'],
            [[]]
        ];
    }

    public function validMatchProvider(): array
    {
        return [
            [
                'f81d4fae-7dec-11d0-a765-00a0c91e6bf6',
                '/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i'
            ],
            [
                'https://www.google.com/search?client=ubuntu&channel=fs&q=regular+expressions&ie=utf-8&oe=utf-8',
                '/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?$/'
            ],
            [
                '192.168.0.1',
                '/^(?:(?:(?:2[0-4]|1[0-9]|[1-9])?[0-9]|25[0-5])\.){3}(?:(?:2[0-4]|1[0-9]|[1-9])?[0-9]|25[0-5])$/'
            ]
        ];
    }

    public function invalidMatchProvider(): array
    {
        return [
            [
                'f81d4fae-7dec-11d0-a76500-a0c91e6bf6',
                '/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i'
            ],
            [
                'https://www.google.com/search?client=ubuntu&channel=fs&q=regular+expressions&ie=utf-8&oe=utf-8',
                '/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))$/'
            ],
            [
                '192.168.000.001',
                '/^(?:(?:(?:2[0-4]|1[0-9]|[1-9])?[0-9]|25[0-5])\.){3}(?:(?:2[0-4]|1[0-9]|[1-9])?[0-9]|25[0-5])$/'
            ],
            [
                [],
                '/.*/'
            ]
        ];
    }

    public function validContainsProvider(): array
    {
        return [
            ['services@example.com', 'example'],
            ['https://www.google.com', '://'],
            ['file:///etc/hosts', '///']
        ];
    }

    public function invalidContainsProvider(): array
    {
        return [
            ['services@example.com', 'google'],
            ['https://www.google.com', '::'],
            ['file:///etc/hosts', 'www'],
            [[], 'array']
        ];
    }

    public function validStartsWithProvider(): array
    {
        return [
            ['services@example.com', 'services'],
            ['https://www.google.com', 'https:'],
            ['file:///etc/hosts', 'file:']
        ];
    }

    public function invalidStartsWithProvider(): array
    {
        return [
            ['services@example.com', 'admin'],
            ['https://www.google.com', 'http:'],
            ['file:///etc/hosts', '/'],
            [[], 'array']
        ];
    }

    public function validEndsWithProvider(): array
    {
        return [
            ['services@example.com', 'example.com'],
            ['https://www.google.com', 'google.com'],
            ['file:///etc/hosts', 'hosts']
        ];
    }

    public function invalidEndsWithProvider(): array
    {
        return [
            ['services@example.com', 'example.org'],
            ['https://www.google.com', 'yahoo.com'],
            ['file:///etc/hosts', 'interfaces'],
            [[], 'array']
        ];
    }

    public function validExactLengthProvider(): array
    {
        return [
            ['hello world', 11]
        ];
    }

    public function invalidExactLengthProvider(): array
    {
        return [
            ['hello world!', 11],
            [[], 2],
            [new \ArrayObject(), 0]
        ];
    }

    public function validMinLengthProvider(): array
    {
        return [
            ['hello', 2],
            ['hello', 5]
        ];
    }

    public function invalidMinLengthProvider(): array
    {
        return [
            ['hello', 6],
            [[], 0],
            [new \ArrayObject(), 0]
        ];
    }

    public function validMaxLengthProvider(): array
    {
        return [
            ['hello', 10],
            ['hello', 5]
        ];
    }

    public function invalidMaxLengthProvider(): array
    {
        return [
            ['hello', 2],
            [[], 100],
            [new \ArrayObject(), 100]
        ];
    }

    public function validRangeLengthProvider(): array
    {
        return [
            ['hello', 5, 10],
            ['hello', 2, 5],
            ['hello', 1, 10]
        ];
    }

    public function invalidRangeLengthProvider(): array
    {
        return [
            ['hello', 6, 20],
            ['hello', 2, 3],
            [[], 0, 100],
            [new \ArrayObject(), 0, 100]
        ];
    }

    public function validExactNumberProvider(): array
    {
        return [
            ['42', 42],
            ['3.14', 3.14],
            ['17.0', 17],
            [42, 42],
            [3.14, 3.14],
            [17.0, 17]
        ];
    }

    public function invalidExactNumberProvider(): array
    {
        return [
            ['42.1', 42],
            ['apples', 12],
            [[], 0],
            [new \ArrayObject(), 0]
        ];
    }

    public function validMinNumberProvider(): array
    {
        return [
            ['42', 42],
            ['3.14', 3.14],
            ['17.0', 17],
            [42, 20],
            [3.14, 3],
            [17.0, 7]
        ];
    }

    public function invalidMinNumberProvider(): array
    {
        return [
            ['42.1', 50],
            ['apples', 12],
            [[], 0],
            [new \ArrayObject(), 0]
        ];
    }

    public function validMaxNumberProvider(): array
    {
        return [
            ['42', 42],
            ['3.14', 3.14],
            ['17.0', 17],
            [42, 50],
            [3.14, 5],
            [17.0, 20]
        ];
    }

    public function invalidMaxNumberProvider(): array
    {
        return [
            ['42.1', 40],
            ['apples', 12],
            [[], 100],
            [new \ArrayObject(), 100]
        ];
    }

    public function validRangeNumberProvider(): array
    {
        return [
            ['42', 40, 42],
            ['3.14', 3.14, 4],
            ['17.0', 15, 20],
            [42, 40, 50],
            [3.14, 2, 5],
            [17.0, 10, 20]
        ];
    }

    public function invalidRangeNumberProvider(): array
    {
        return [
            ['42.1', 20, 30],
            ['17.3', 20, 30],
            ['apples', 1, 12],
            [[], 0, 100],
            [new \ArrayObject(), 0, 100]
        ];
    }

    public function validWholeNumberProvider(): array
    {
        return [
            ['42'],
            [42],
            ['7.0'],
            [1.0],
            ['0']
        ];
    }

    public function invalidWholeNumberProvider(): array
    {
        return [
            ['-17'],
            [-1],
            ['3.14'],
            ['apples'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validNaturalNumberProvider(): array
    {
        return [
            ['42'],
            [42],
            ['7.0'],
            [1.0]
        ];
    }

    public function invalidNaturalNumberProvider(): array
    {
        return [
            ['-17'],
            [0],
            ['3.14'],
            ['apples'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validIntValueProvider(): array
    {
        return [
            ['42'],
            [42],
            ['7.0'],
            [1.0],
            ['0']
        ];
    }

    public function invalidIntValueProvider(): array
    {
        return [
            ['-17.01'],
            [0.1],
            ['3.14'],
            ['apples'],
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validExactCountProvider(): array
    {
        return [
            [['one', 'two', 'three'], 3],
            [['foo', 'bar'], 2]
        ];
    }

    public function invalidExactCountProvider(): array
    {
        return [
            [['one', 'two', 'three'], 2],
            ['foo', 2]
        ];
    }

    public function validMinCountProvider(): array
    {
        return [
            [['one', 'two', 'three'], 3],
            [['foo', 'bar'], 1]
        ];
    }

    public function invalidMinCountProvider(): array
    {
        return [
            [['one', 'two', 'three'], 4],
            ['foo', 1]
        ];
    }

    public function validMaxCountProvider(): array
    {
        return [
            [['one', 'two', 'three'], 3],
            [['foo', 'bar'], 3]
        ];
    }

    public function invalidMaxCountProvider(): array
    {
        return [
            [['one', 'two', 'three'], 2],
            ['foo', 1]
        ];
    }

    public function validRangeCountProvider(): array
    {
        return [
            [['one', 'two', 'three'], 1, 3],
            [['foo', 'bar'], 0, 5]
        ];
    }

    public function invalidRangeCountProvider(): array
    {
        return [
            [['one', 'two', 'three'], 10, 20],
            [['one', 'two', 'three'], 0, 2],
            ['foo', 1, 5]
        ];
    }

    public function validOneOfProvider(): array
    {
        return [
            ['bar', ['foo', 'bar', 'baz']]
        ];
    }

    public function invalidOneOfProvider(): array
    {
        return [
            ['buz', ['foo', 'bar', 'baz']]
        ];
    }

    public function validKeyIssetProvider(): array
    {
        return [
            [['foo' => 'bar'], 'foo'],
            [['foo' => ''], 'foo']
        ];
    }

    public function invalidKeyIssetProvider(): array
    {
        return [
            [['foo' => null], 'foo'],
            ['bar', 'foo']
        ];
    }

    public function validKeyNotEmptyProvider(): array
    {
        return [
            [['foo' => 'bar'], 'foo'],
            [['foo' => ['one']], 'foo']
        ];
    }

    public function invalidKeyNotEmptyProvider(): array
    {
        return [
            [['foo' => ''], 'foo'],
            ['bar', 'foo']
        ];
    }

    public function validEqualProvider(): array
    {
        return [
            [42, '42'],
            [3.14, '3.14'],
            [0, false],
            ['', null],
            [1, true],
            [new TestStringObject('hello'), new TestStringObject('hello')]
        ];
    }

    public function invalidEqualProvider(): array
    {
        return [
            [41, '42'],
            [3.14, '3.17'],
            ['1', false],
            [new \StdClass(), null],
            [0, true],
            [new TestStringObject('hello'), new TestStringObject('Hello')]
        ];
    }

    public function validNotEqualProvider(): array
    {
        return [
            [41, '42'],
            [3.14, '3.17'],
            ['1', false],
            [new \StdClass(), null],
            [0, true],
            [new TestStringObject('hello'), new TestStringObject('Hello')]
        ];
    }

    public function invalidNotEqualProvider(): array
    {
        return [
            [42, '42'],
            [3.14, '3.14'],
            [0, false],
            ['', null],
            [1, true],
            [new TestStringObject('hello'), new TestStringObject('hello')]
        ];
    }

    public function validSameProvider(): array
    {
        $obj = new \StdClass();

        return [
            [$obj, $obj],
            [[], []],
            [42, 42],
            [3.14, 3.14]
        ];
    }

    public function invalidSameProvider(): array
    {
        return [
            [new \StdClass(), new \StdClass()],
            [42, '42'],
            [3.14, '3.14'],
            [1, true]
        ];
    }

    public function validNotSameProvider(): array
    {
        return [
            [new \StdClass(), new \StdClass()],
            [42, '42'],
            [3.14, '3.14'],
            [1, true]
        ];
    }

    public function invalidNotSameProvider(): array
    {
        $obj = new \StdClass();

        return [
            [$obj, $obj],
            [[], []],
            [42, 42],
            [3.14, 3.14]
        ];
    }

    public function validSameTypeProvider(): array
    {
        return [
            [new \StdClass(), new \StdClass()],
            [42, 17],
            [3.17, 1.119],
            ['foo', 'bar']
        ];
    }

    public function invalidSameTypeProvider(): array
    {
        return [
            [new \StdClass(), new \DateTime()],
            [42, 3.17],
            [17, 1.119],
            ['foo', true]
        ];
    }

    public function validTypeProvider(): array
    {
        return [
            ['hello', 'string'],
            [true, 'bool'],
            [3.14, 'float'],
            [17, 'int'],
            [42, 'int'],
            [['foo'], 'array'],
            [function () {}, 'callable'],
            ['42', 'string'],
            [new \StdClass(), 'object'],
            [123.456, 'float'],
            [new \DateTime(), 'DateTime'],
            [['anything'], null]
        ];
    }

    public function invalidTypeProvider(): array
    {
        return [
            ['hello', 'bool'],
            [true, 'float'],
            [3.14, 'int'],
            [17, 'double'],
            [42, 'array'],
            [['foo'], 'callable'],
            [function () {}, 'numeric'],
            ['42', 'object'],
            [new \StdClass(), 'scalar'],
            [123.456, 'DateTime'],
            [new \DateTime(), 'string']
        ];
    }

    public function validListOfProvider(): array
    {
        return [
            [['foo', 'bar', 'baz'], 'string'],
            [[1, 2, 3], 'int'],
            [[new \DateTime(), new \DateTime()], 'DateTime'],
            [['foo', 1, 3.14], null]
        ];
    }

    public function invalidListOfProvider(): array
    {
        return [
            [['foo', 'bar', 'baz'], 'DateTime'],
            [[1, 2, 3], 'string'],
            [[new \DateTime(), new \DateTime()], 'int'],
            ['foo', 'bar']
        ];
    }

    public function validStringCastableProvider(): array
    {
        return [
            ['hello'],
            [null],
            [true],
            [42],
            [3.14],
            [new TestStringObject('hello')]
        ];
    }

    public function invalidStringCastableProvider(): array
    {
        return [
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function validJsonEncodableProvider(): array
    {
        return [
            [null],
            ['foo'],
            [['foo' => 'bar']],
            [new TestStringObject('hello')]
        ];
    }

    public function invalidJsonEncodableProvider(): array
    {
        $string = 'Hello World';
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $string);
        rewind($stream);

        return [
            [$stream],
            [['stream' => $stream]],
            [['number' => INF]]
        ];
    }

    public function validTraversableProvider(): array
    {
        return [
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function invalidTraversableProvider(): array
    {
        return [
            ['foo'],
            [new \DateTime()]
        ];
    }

    public function validCountableProvider(): array
    {
        return [
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function invalidCountableProvider(): array
    {
        return [
            ['foo'],
            [new \DateTime()]
        ];
    }

    public function validArrayAccessibleProvider(): array
    {
        return [
            [[]],
            [new \ArrayObject()]
        ];
    }

    public function invalidArrayAccessibleProvider(): array
    {
        return [
            ['foo'],
            [new \DateTime()]
        ];
    }

    public function validComparableProvider(): array
    {
        return [
            [new TestStringObject('foo')]
        ];
    }

    public function invalidComparableProvider(): array
    {
        return [
            [new \DateTime()]
        ];
    }

    public function validEquatableProvider(): array
    {
        return [
            [new TestStringObject('foo')]
        ];
    }

    public function invalidEquatableProvider(): array
    {
        return [
            [new \DateTime()]
        ];
    }

    public function validImplementsProvider(): array
    {
        return [
            [new \DateTime(), 'DateTimeInterface'],
            ['DateTime', 'DateTimeInterface'],
            ['Iterator', 'Traversable']
        ];
    }

    public function invalidImplementsProvider(): array
    {
        return [
            [new \ArrayObject(), 'DateTimeInterface'],
            ['ArrayObject', 'DateTimeInterface'],
            ['Foobarbazbuz', 'DateTimeInterface']
        ];
    }

    public function validInstanceOfProvider(): array
    {
        return [
            [new \DateTime(), 'DateTime'],
            [new \DateTime(), 'DateTimeInterface']
        ];
    }

    public function invalidInstanceOfProvider(): array
    {
        return [
            [new \ArrayObject(), 'DateTimeInterface'],
            ['ArrayObject', 'ArrayObject']
        ];
    }

    public function validSubclassOfProvider(): array
    {
        return [
            [new \SplQueue(), 'SplDoublyLinkedList'],
            ['SplQueue', 'SplDoublyLinkedList'],
            ['DateTime', 'DateTimeInterface']
        ];
    }

    public function invalidSubclassOfProvider(): array
    {
        return [
            [new \ArrayObject(), 'DateTimeInterface'],
            ['DateTime', 'DateTime']
        ];
    }

    public function validClassExistsProvider(): array
    {
        return [
            ['DateTime']
        ];
    }

    public function invalidClassExistsProvider(): array
    {
        return [
            ['Foobarbazbuz'],
            [[]]
        ];
    }

    public function validInterfaceExistsProvider(): array
    {
        return [
            ['Iterator']
        ];
    }

    public function invalidInterfaceExistsProvider(): array
    {
        return [
            ['Foobarbazbuz'],
            [[]]
        ];
    }

    public function validMethodExistsProvider(): array
    {
        return [
            ['format', new \DateTime()],
            ['format', 'DateTime']
        ];
    }

    public function invalidMethodExistsProvider(): array
    {
        return [
            ['foobar', new \DateTime()],
            [[], 'DateTime']
        ];
    }

    public function validPathProvider(): array
    {
        return [
            ['vfs://root/app/config'],
            ['vfs://root/app/config/parameters.yml'],
            ['vfs://root/app/cache/container.php']
        ];
    }

    public function invalidPathProvider(): array
    {
        return [
            ['vfs://root/app/config/local.yml'],
            ['vfs://root/app/storage'],
            [[]]
        ];
    }

    public function validFileProvider(): array
    {
        return [
            ['vfs://root/app/config/config.yml'],
            ['vfs://root/app/config/parameters.yml'],
            ['vfs://root/app/cache/container.php']
        ];
    }

    public function invalidFileProvider(): array
    {
        return [
            ['vfs://root/app/config/local.yml'],
            ['vfs://root/app/config/secret.yml'],
            [[]]
        ];
    }

    public function validDirProvider(): array
    {
        return [
            ['vfs://root/app/config'],
            ['vfs://root/app/cache']
        ];
    }

    public function invalidDirProvider(): array
    {
        return [
            ['vfs://root/app/storage'],
            [[]]
        ];
    }

    public function validReadableProvider(): array
    {
        return [
            ['vfs://root/app/config/config.yml'],
            ['vfs://root/app/config']
        ];
    }

    public function invalidReadableProvider(): array
    {
        return [
            [[]]
        ];
    }

    public function validWritableProvider(): array
    {
        return [
            ['vfs://root/app/cache/container.php'],
            ['vfs://root/app/cache']
        ];
    }

    public function invalidWritableProvider(): array
    {
        return [
            [[]]
        ];
    }

    protected function createFilesystem()
    {
        $vfs = $this->createVfs([
            'app' => [
                'config' => [
                    'config.yml'     => 'foo: bar',
                    'parameters.yml' => 'secret: password'
                ],
                'cache'  => [
                    'container.php' => "<?php\n\nclass Container\n{\n}\n"
                ]
            ]
        ]);
        /** @var vfsStreamDirectory $appDir */
        $appDir = $vfs->getChild('app');
        /** @var vfsStreamDirectory $configDir */
        $configDir = $appDir->getChild('config');
        $configDir->chown(vfsStream::OWNER_ROOT);
        $configDir->chmod(0755);
        $config = $configDir->getChild('config.yml');
        $config->chown(vfsStream::OWNER_ROOT);
        $config->chmod(0644);
        $parameters = $configDir->getChild('parameters.yml');
        $parameters->chown(vfsStream::OWNER_ROOT);
        $parameters->chmod(0600);
    }
}
