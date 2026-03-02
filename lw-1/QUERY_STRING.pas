PROGRAM PrintName(INPUT, OUTPUT);
USES
  DOS;

VAR
  QueryString: STRING;

FUNCTION GetQueryStringParameter(Key: STRING): STRING;
VAR
  PosStr: INTEGER;
  Str, Temp: STRING;
BEGIN
  Str := ' ';
  QueryString := '&' + QueryString;
  Key := '&' + Key + '=';

  PosStr := Pos(Key, QueryString);
  IF PosStr > 0
  THEN
    BEGIN
      Temp := Copy(QueryString, PosStr + Length(Key), Length(QueryString));
      PosStr := Pos('&', Temp);
      IF PosStr > 0
      THEN
        Str := Copy(Temp, 1, PosStr - 1)
      ELSE
        Str := Copy(Temp, 1, Length(Temp))
    END;

  GetQueryStringParameter := Str
END;

BEGIN
  QueryString := GetEnv('QUERY_STRING');

  WRITELN('Content-Type: text/plain');
  WRITELN;
  WRITELN('First Name: ', GetQueryStringParameter('first_name'));
  WRITELN('Last Name: ', GetQueryStringParameter('last_name'));
  WRITELN('Age: ', GetQueryStringParameter('age'))
END.