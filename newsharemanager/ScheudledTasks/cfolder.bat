@echo off
net use \\%1\%4$ /user:%2 %3
md \\%1\%4$\%5
echo SUCCESS