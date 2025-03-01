function z = fitfuncGAEx3(Chromo)
%Chromo = [x x x x x x x] represents 7 digits of decimal number implying 28 bits chromosome
%i = 4 bits length
z = 0;
for i = 4:-1:1    % start with left most bit
    for j = 1:length(Chromo)
        x(j) = bitget(Chromo(j), i);
    end
    a = (((x(1) * 20) + (x(2) * 15) + (x(3) * 35) + (x(4) * 40) + (x(5) * 15) + (x(6) * 15) + (x(7) * 10)));
    b(i) = 150 - a;
end
c(1) = b(4) - 80; 
c(2) = b(3) - 90; 
c(3) = b(2) - 65; 
c(4) = b(1) - 70;

if ((c(1) < 20) | (c(2) < 20) | (c(3) < 20) | (c(4) < 20))
    z = 0;
    return;
end

z = c(1) + c(2) + c(3) + c(4);

end
